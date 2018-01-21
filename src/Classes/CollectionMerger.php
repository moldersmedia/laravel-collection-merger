<?php namespace MoldersMedia\CollectionMerger\Classes;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CollectionMerger
 * @package MoldersMedia\CollectionMerger\Classes
 */
class CollectionMerger
{
    /**
     * @var array
     */
    private $collections = [];

    /**
     * @param Collection $collection
     * @param string|bool $key
     * @return $this
     * @throws \Exception
     */
    public function attach(Collection $collection, $key = false)
    {
        // No key is given so auto detect
        if (!$key && $collection->count()) {
            $model = $collection->first();

            $key = $this->getKeyFromModel($model);
        }

        if (!$this->has($key)) {
            $this->collections[$key] = $collection;

            return $this;
        }

        /** @var Collection $eloquentCollection */
        $eloquentCollection = $this->collections[$key];

        $this->collections[$key] = $eloquentCollection->merge($collection);

        return $this;
    }

    /**
     * @param $key
     * @return Collection
     */
    public function get($key)
    {
        return $this->collections[$key] ?? new Collection();
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->collections);
    }

    /**
     * @param $key
     * @return bool
     */
    public function filled($key)
    {
        if ($this->has($key)) {
            return (bool)$this->get($key)->count();
        }

        return false;
    }

    /**
     * @param $key
     * @return $this
     */
    public function forget($key)
    {
        if ($this->has($key)) {
            unset($this->collections[$key]);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function flush()
    {
        $this->collections = [];

        return $this;
    }

    /**
     * @param Model $model
     * @return string
     * @throws \Exception
     */
    private function getKeyFromModel(Model $model)
    {
        # Curly braces are for ignoring IDE errors on magic properties
        $key = $model->{'collectionMerger'};

        if (!$key) {
            throw new \Exception('You should set a public $collectionMerger in your model: ' . get_class($model));
        }

        return $key;
    }
}