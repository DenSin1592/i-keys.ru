<?php

namespace App\Services\DataProviders\ProductListPage\ProductTypePage;

use App\Models\Category;
use App\Models\ProductTypePage;
use App\Services\DataProviders\ClientProductList\ClientProductList;
use App\Services\DataProviders\ProductListPage\FilterVariantsProvider;
use Illuminate\Database\Eloquent\Collection;

class DefaultProductTypePageProductList extends ProductTypePageProductListProvider
{
    /**
     * DefaultProductTypePageProductList constructor.
     * @param FilterVariantsProvider $filterVariantsProvider
     * @param ClientProductList $productListProvider
     * @param ProductTypePage $productTypePage
     * @param Category $category
     * @param array $filterData
     * @param $sort
     * @param $productsView
     */
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
            $productTypePage,
            $category,
            $filterData,
            $sort,
            $productsView
        );
    }

    protected function getPaginator($page)
    {
        return \PrettyPaginator::makeFromCallback(
            function ($page, $limit) {
                return [
                    'items' => Collection::make([]),
                    'total' => 0,
                    'limit' => $limit,
                    'page' => $page,
                ];
            },
            \UrlBuilder::getUrl($this->productTypePage),
            $page,
            self::ELEMENTS_ON_PAGE,
            ['sort' => $this->sort, 'view' => $this->productsView]
        );
    }
}