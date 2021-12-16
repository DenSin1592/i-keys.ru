<?php

namespace App\Services\DataProviders\ClientProduct\Plugins;

use App\Models\Product;
use App\Services\DataProviders\ClientProduct\ClientProductPlugin;
use App\Services\DataProviders\ClientProductList\ClientProductList;
use App\Services\Repositories\Product\EloquentProductRepository;

class RelatedProducts implements ClientProductPlugin
{
    private $productRepository;
    private $productListProvider;

    /**
     * RelatedProducts constructor.
     * @param EloquentProductRepository $productRepository
     * @param ClientProductList $productListProvider
     */
    public function __construct(EloquentProductRepository $productRepository, ClientProductList $productListProvider)
    {
        $this->productRepository = $productRepository;
        $this->productListProvider = $productListProvider;
    }

    public function getForProduct(Product $product): array
    {
        $relatedProducts = $this->productRepository->relatedProductsForProduct($product, true);
        $relatedProductsData = $this->productListProvider->getProductListData($relatedProducts);

        return ['relatedProductsData' => $relatedProductsData];
    }

}