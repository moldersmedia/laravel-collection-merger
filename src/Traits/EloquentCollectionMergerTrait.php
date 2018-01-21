<?php namespace MoldersMedia\CollectionMerger\Traits;

use Illuminate\Database\Eloquent\Collection;
use MoldersMedia\CollectionMerger\Classes\CollectionMerger;

/**
 * Trait EloquentCollectionMergerTrait
 *
 * A trait to chunk DB requests and merge all collected items quickly
 *
 * @method chunk(int $perPage, \Closure $closure)
 * @property bool collectionMerger
 * @property int collectionMergerPerChunk
 *
 * @package MoldersMedia\CollectionMerger\Traits
 */
trait EloquentCollectionMergerTrait
{
    /**
     * @param int $perChunk
     * @param bool $key
     * @return Collection
     */
    public function chunkAndMerge(int $perChunk = null, $key = false)
    {
        $this->chunk($this->getChunkAmount($perChunk), function (Collection $collection) {
            $this->getCollectionMerger()->attach($collection);
        });

        return $this->getCollectionMerger()->get($this->getCollectionMergerKey($key));
    }

    /**
     * @param $key
     * @return bool
     */
    protected function getCollectionMergerKey($key)
    {
        return $key ? $key : $this->collectionMerger;
    }

    /**
     * @param $amount
     * @return int
     */
    protected function getChunkAmount($amount)
    {
        return $amount ? $amount : $this->collectionMergerPerChunk;
    }

    /**
     * @return CollectionMerger
     */
    public function getCollectionMerger()
    {
        return app('CollectionMerger');
    }
}