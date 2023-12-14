<?php

namespace Sarfrazrizwan\LaravelMergeTags;

trait HasMergeTag
{
    /**
     * Key prefix for parseable text
     *
     * @var string|null
     */

    protected $parseabelTextPrefix = null;

    /**
     * Key prefix separator for parseable text
     *
     * @var string
     */

    protected $parseabelTextPrefixSeparator = '_';


    abstract public function parseableKeyVales();

    public function setParseabelTextPrefix($prefix)
    {
        $this->parseabelTextPrefix = $prefix;
    }

    public function getParseabelTextPrefix()
    {
        return $this->parseabelTextPrefix ?? strtolower(class_basename($this));
    }

    public function getMappedKeyValues()
    {
        $prefix = $this->getParseabelTextPrefix();

        return collect($this->parseableKeyVales())
            ->map(function ($item) use($prefix){

                if (!isset($item['value']))
                    $item['value'] = $this->{$item['key']};

                $item['key'] = "{$prefix}{$this->parseabelTextPrefixSeparator}{$item['key']}";

                if (!isset($item['label']))
                    $item['label'] = ucfirst(str()->replace($this->parseabelTextPrefixSeparator, ' ', $item['key']));
                return $item;
            })->toArray();
    }

}