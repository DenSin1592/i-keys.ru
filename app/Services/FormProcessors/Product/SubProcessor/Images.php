<?php namespace App\Services\FormProcessors\Product\SubProcessor;

use App\Models\Product;
use App\Services\FormProcessors\Product\SubProcessor;
use App\Services\Repositories\ProductImage\EloquentProductImageRepository;

class Images implements SubProcessor
{
    private $imageRepository;

    public function __construct(EloquentProductImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function prepareInputData(array $data)
    {
        return $data;
    }

    public function save(Product $product, array $data)
    {
        $imageListData = \Arr::get($data, 'images', []);
        if (!is_array($imageListData)) {
            return;
        }

        $currentIds = $product->images->pluck('id')->all();
        $touchedIds = [];
        foreach ($imageListData as $imageData) {
            $image = $this->imageRepository->createOrUpdateForProduct($product, $imageData);
            $touchedIds[] = $image->id;
        }

        $idsToDelete = array_diff($currentIds, $touchedIds);
        foreach ($idsToDelete as $idToDelete) {
            $this->imageRepository->deleteById($idToDelete);
        }
    }
}
