<?php

namespace App\Services\DataProviders\ProductListPage\ProductTypePage;

use App\Models\Category;
use App\Models\ProductTypePage;
use App\Services\DataProviders\ClientProductList\ClientProductList;
use App\Services\DataProviders\ProductListPage\FilterVariantsProvider;
use App\Services\Repositories\Product\EloquentProductRepository;

class ManualProductTypePageProductList extends ProductTypePageProductListProvider
{
    private $productRepository;

    /**
     * ManualProductTypePageProductList constructor.
     * @param EloquentProductRepository $productRepository
     * @param FilterVariantsProvider $filterVariantsProvider
     * @param ClientProductList $productListProvider
     * @param ProductTypePage $productTypePage
     * @param Category $category
     * @param $sort
     * @param $productsView
     */
    public function __construct(
        EloquentProductRepository $productRepository,
        FilterVariantsProvider $filterVariantsProvider,
        ClientProductList $productListProvider,
        ProductTypePage $productTypePage,
        Category $category,
        $sort,
        $productsView
    ) {
        parent::__construct(
            $filterVariantsProvider,
            $productListProvider,
            $productTypePage,
            $category,
            [],
            $sort,
            $productsView
        );

        $this->productRepository = $productRepository;
    }

    protected function getPaginator($page)
    {
        return \PrettyPaginator::makeFromCallback(
            function ($page, $limit) {
                return $this->productRepository->publishedManualForProductTypePageByPage(
                    $this->productTypePage,
                    $page,
                    $limit,
                    $this->sort
                );
            },
            \UrlBuilder::getUrl($this->productTypePage),
            $page,
            self::ELEMENTS_ON_PAGE,
            ['sort' => $this->sort, 'view' => $this->productsView]
        );
    }
}