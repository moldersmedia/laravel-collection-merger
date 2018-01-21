<?php namespace MoldersMedia\CollectionMerger\Facades;

use Illuminate\Support\Facades\Facade;

class CollectionMerger extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return CollectionMerger::class;
    }
}
