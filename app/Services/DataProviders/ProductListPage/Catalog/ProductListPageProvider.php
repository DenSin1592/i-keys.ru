<?php

namespace App\Services\DataProviders\ProductListPage\Catalog;

use App\Models\Category;
use App\Services\DataProviders\ClientProductList\ClientProductList;
use App\Services\DataProviders\ProductListPage\FilterVariantsProvider;

abstract class ProductListPageProvider
{
    protected const ELEMENTS_ON_PAGE = 11;


    public function __construct(
        protected FilterVariantsProvider $filterVariantsProvider,
        protected ClientProductList $productListProvider,
        protected Category $category,
        protected array $filterData,
        protected ?string $sort,
        protected ?string $productsView
    ){}


    public function getProductListData(?int $page): array
    {
        $filterVariants = $this->getFilterVariants();
        $paginator = $this->getPaginator($page);

        $products = $paginator->items();
        $productsData = $this->getProductsData($products);

        $data = [
            'paginator' => $paginator,
            'productsData' => $productsData,
            'filter' => $filterVariants,
            'category' => $this->category,
        ];

        return $data;
    }


    protected function getFilterVariants()
    {
        return $this->filterVariantsProvider->getFilterVariants(
            $this->category,
            $this->filterData,
            $this->sort,
            $this->productsView
        );
    }

    protected function getProductsData($products)
    {
        return $this->productListProvider->getProductListData($products);
    }


    abstract protected function getPaginator($page);
}
