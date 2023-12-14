<?php

namespace Sarfrazrizwan\LaravelMergeTags;

use Illuminate\Support\Facades\Facade;

/**
 * @method static setModel()
 * @method static setModels($models)
 * @method static getKeyValues()
 * @method static parse($text)
 */
final class MergeTag extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'mergeTag';
    }
}