<?php

namespace App\Services\DataProviders\ProductListPage\ProductTypePage;

use App\Models\Category;
use App\Models\ProductTypePage;
use App\Services\DataProviders\ClientProductList\ClientProductList;
use App\Services\DataProviders\ProductListPage\FilterVariantsProvider;
use App\Services\Repositories\Product\EloquentProductRepository;

class FilteredProductTypePageProductList extends ProductTypePageProductListProvider
{
    private $productRepository;

    /**
     * FilteredProductTypePageProductList constructor.
     * @param EloquentProductRepository $productRepository
     * @param FilterVariantsProvider $filterVariantsProvider
     * @param ClientProductList $productListProvider
     * @param ProductTypePage $productTypePage
     * @param Category $category
     * @param array $filterData
     * @param $sort
     * @param $productsView
     */
    public function __construct(
        EloquentProductRepository $productRepository,
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
            $productTypePage,
            $category,
            $filterData,
            $sort,
            $productsView
        );

        $this->productRepository = $productRepository;
    }

    protected function getPaginator($page)
    {
        $paginatorQueryData = ['view' => $this->productsView];
        $requestSort = \Request::get('sort');
        if (is_string($requestSort)) {
            $paginatorQueryData['sort'] = $requestSort;
        }

        return \PrettyPaginator::makeFromCallback(
            function ($page, $limit) {
                return $this->productRepository->publishedFilteredForProductTypePageByPage(
                    $this->category,
                    $this->productTypePage,
                    $page,
                    $limit,
                    $this->filterData,
                    $this->sort
                );
            },
            \UrlBuilder::getUrl($this->productTypePage),
            $page,
            self::ELEMENTS_ON_PAGE,
            $paginatorQueryData
        );
    }
}