<?php

namespace App\Services\DataProviders\ProductListPage\ProductTypePage;

use App\Models\Category;
use App\Models\ProductTypePage;
use App\Services\DataProviders\ClientProductList\ClientProductList;
use App\Services\DataProviders\ProductListPage\FilterVariantsProvider;
use App\Services\DataProviders\ProductListPage\Catalog\ProductListPageProvider;

abstract class ProductTypePageProductListProvider extends ProductListPageProvider
{
    protected $productTypePage;

    public function __construct(
        FilterVariantsProvider $filterVariantsProvider,
        ClientProductList $productListProvider,
        ProductTypePage $productTypePage,
        Category $category,
        array $filterData,
        $sort,
        $productsView
    ) {
        parent::__construct(
            $filterVariantsProvider,
            $productListProvider,
            $category,
            $filterData,
            $sort,
            $productsView
        );

        $this->productTypePage = $productTypePage;
    }

    protected function getFilterVariants()
    {
        $filterVariants = parent::getFilterVariants();

        $filterVariants['currentFilterQuery']['product_type_page'] = $this->productTypePage->id;

        return $filterVariants;
    }

    protected function getProductsData($products)
    {
        return $this->productListProvider->getProductListData($products, ['productTypePage' => $this->productTypePage]);
    }
}