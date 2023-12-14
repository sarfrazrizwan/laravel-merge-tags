<?php

namespace Sarfrazrizwan\LaravelMergeTags;

use Sarfrazrizwan\LaravelMergeTags\HasMergeTag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class LaravelMergeTags
{

    protected $keyValues = [];
    protected $models = [];

    /**
     * @var array tags that indicate a value that should be parsed
     */
    protected $tags    = ["[", "]"];

    public function __construct()
    {

    }

    public static function make()
    {
        return new self;
    }
    /**
     * Register a new model.
     *
     * @param \Illuminate\Database\Eloquent\Model|string $model
     * @return $this
     * */

    public function setModel($model)
    {
        if (!$model instanceof Model)
            $model = new $model;

        //todo: move to separate class

        if (!in_array(HasMergeTag::class, class_uses_recursive($model)))
            throw new \Exception("Class must have Trait");

        $updated = false;
        foreach ($this->models as $key => $value) {
            if ($value instanceof $model){
                $this->models[$key] = $model;
                $updated = true;
                break;
            }
        }

//        if (!$updated)
            $this->models[] = $model;

        $this->setKeyValues();

        return $this;
    }

    /**
     * Register new models.
     *
     * @param Collection<\Illuminate\Database\Eloquent\Model |string > | array<\Illuminate\Database\Eloquent\Model |string > $models
     * @return $this
     *
     * */

    public function setModels($models)
    {
        foreach ($models as $model) {
            $this->setModel($model);
        }

        return $this;
    }


    /**
     * Hydrate models.
     *
     * @param array<\Illuminate\Database\Eloquent\Model> $models
     * @return $this
     * */

    public function hydrate($models): array
    {
        foreach ($models as $model) {
            $this->setModel($model);
        }
        return $this;
    }

    /**
     * Get key values pair.
     *
     * @return array
     * */

    public function getKeyValues(): array
    {
        return $this->keyValues;
    }

    /**
     * Set key values pair.
     *
     * @return array
     * */

    public function setKeyValues(): array
    {
        $keyValues = [];
        foreach ($this->models as $model) {
            $keyValues = array_merge($keyValues, $model->getMappedKeyValues());
        }

        $this->keyValues = collect($keyValues)->map(function ($item){
            $item['key'] = $this->tags[0].$item['key'].$this->tags[1];
            return $item;
        })->toArray();

        return $this->keyValues;
    }

    /**
     * Get value by key.
     *
     * @return string
     * */

    public function getValue($key)
    {
        return collect($this->keyValues)->firstWhere('key', $key)['value'] ?? '';
    }

    /**
     * Map the given key values into in tags format.
     * @param array
     * @return array
     * */


    public function parse($text)
    {
        $doc = new \DOMDocument();
        $doc->loadHTML('<?xml encoding="UTF-8">' . $text, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOXMLDECL);

        foreach (iterator_to_array($doc->getElementsByTagName('span')) as $node){
            $key = $node->getAttribute('data-placeholder');
            if ($key){
                $node->textContent = $this->getValue($key);
            }
        }

        return str_replace('<?xml encoding="UTF-8">', '', $doc->saveHTML());
    }
}
