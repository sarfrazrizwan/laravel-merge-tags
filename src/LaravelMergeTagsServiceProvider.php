<?php

namespace Sarfrazrizwan\LaravelMergeTags;

use Illuminate\Support\ServiceProvider;

class LaravelMergeTagsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/merge-tags.php' => config_path('merge-tags.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'merge-tags');

        // Register the main class to use with the facade

        $this->app->singleton(MergeTag::class, static function () {
            return LaravelMergeTags::make();
        });

        $this->app->alias(MergeTag::class, 'mergeTag');
    }
}
