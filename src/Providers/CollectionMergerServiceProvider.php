<?php namespace MoldersMedia\CollectionMerger\Providers;

use Illuminate\Support\ServiceProvider;
use MoldersMedia\CollectionMerger\Classes\CollectionMerger;

/**
 * Class CollectionMergerServiceProvider
 * @package MoldersMedia\CollectionMerger\Providers
 */
class CollectionMergerServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function boot()
    {
        $this->registerSingleton();
    }

    /**
     *
     */
    private function registerSingleton()
    {
        $this->app->singleton('CollectionMerger', function () {
            return new CollectionMerger();
        });
    }
}