<?php namespace App\Services\Eloquent;

use Illuminate\Database\Eloquent\Collection;

/**
 * Trait CollectionExtractor
 * @package App\Services\Eloquent
 */
trait CollectionExtractor
{
    /**
     * Merge existing collection with collection from array.
     *
     * @param callable $newInstanceCreator
     * @param array $collectionData
     * @param Collection $existingCollection
     * @return array
     */
    protected function mergeWithArray(
        callable $newInstanceCreator,
        array $collectionData,
        Collection $existingCollection
    ) {
        $collection = [];

        $dictionary = $existingCollection->getDictionary();
        foreach ($collectionData as $key => $modelData) {
            $id = \Arr::get($modelData, 'id');

            if (!isset($dictionary[$id])) {
                $model = $newInstanceCreator();
                $model->id = $id;
            } else {
                $model = $dictionary[$id];
            }
            $model->fill($modelData);

            $collection[$key] = $model;
        }

        return $collection;
    }


    /**
     * Extract collection from array and merge it with existing eloquent collection.
     *
     * @param callable $newInstanceCreator
     * @param array $data
     * @param $dataKey
     * @param Collection $existingCollection
     * @return array|Collection
     */
    protected function extractFromArray(
        callable $newInstanceCreator,
        array $data,
        $dataKey,
        Collection $existingCollection
    ) {
        if (count($data) > 0) {
            $collectionData = \Arr::get($data, $dataKey);
            if (!is_array($collectionData)) {
                $collectionData = [];
            }
            $collection = $this->mergeWithArray($newInstanceCreator, $collectionData, $existingCollection);
        } else {
            $collection = $existingCollection;
        }

        return $collection;
    }
}
