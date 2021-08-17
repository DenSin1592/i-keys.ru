<?php

namespace App\Services\DataProviders\ProductListPage\Catalog;

use App\Models\Category;
use App\Services\DataProviders\ClientProductList\ClientProductList;
use App\Services\DataProviders\ProductListPage\FilterVariantsProvider;
use App\Services\Pagination\PrettyPaginator\Paginator;

abstract class ProductListPageProvider
{
    const ELEMENTS_ON_PAGE = 12;

    /**
     * @var FilterVariantsProvider
     */
    protected $filterVariantsProvider;

    /**
     * @var ClientProductList
     */
    protected $productListProvider;

    /**
     * @var Category
     */
    protected $category;

    /** @var array */
    protected $filterData;

    /** @var string|null */
    protected $sort;

    /** @var  string|null */
    protected $productsView;

    public function __construct(
        FilterVariantsProvider $filterVariantsProvider,
        ClientProductList $productListProvider,
        Category $category,
        array $filterData,
        $sort,
        $productsView
    ) {
        $this->productListProvider = $productListProvider;
        $this->category = $category;
        $this->filterVariantsProvider = $filterVariantsProvider;
        $this->filterData = $filterData;
        $this->sort = $sort;
        $this->productsView = $productsView;
    }

    /**
     * @param $page
     * @return array
     */
    public function getProductListData($page) {
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

    /**
     * @param $page
     * @return \App\Services\Pagination\PrettyPaginator\Paginator
     */
    abstract protected function getPaginator($page);
}