<?php namespace App\Services\DataProviders\ProductForm\ProductSubForm;

use App\Models\Product;
use App\Services\DataProviders\ProductForm\ProductSubForm;
use App\Services\Eloquent\CollectionExtractor;
use App\Services\Repositories\ProductImage\EloquentProductImageRepository;

class Images implements ProductSubForm
{
    use CollectionExtractor;

    private $repository;

    public function __construct(EloquentProductImageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function provideDataFor(Product $product, array $oldInput)
    {
        $images = $this->extractFromArray(
            function () {
                return $this->repository->newInstance();
            },
            $oldInput,
            'images',
            $this->repository->allForProduct($product)
        );

        return ['images' => $images];
    }
}
