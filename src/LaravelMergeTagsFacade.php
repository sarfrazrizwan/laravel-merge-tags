<?php

namespace Sarfrazrizwan\LaravelMergeTags;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Sarfrazrizwan\LaravelMergeTags\Skeleton\SkeletonClass
 */
class LaravelMergeTagsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-merge-tags';
    }
}
