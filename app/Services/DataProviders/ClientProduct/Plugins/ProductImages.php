<?php

namespace App\Services\DataProviders\ClientProduct\Plugins;

use App\Models\Product;
use App\Services\DataProviders\ClientProduct\ClientProductPlugin;
use App\Services\Repositories\ProductImage\EloquentProductImageRepository;


class ProductImages implements ClientProductPlugin
{
    public function __construct(
        private EloquentProductImageRepository $productImageRepository
    ){}

    public function getForProduct(Product $product): array
    {
        $images = $this->productImageRepository->publishedForProduct($product);
        $images = $images->filter(
            function ($image) {
                return $image->getAttachment('image')->exists();
            }
        );

        return ['images' => $images];
    }
}
