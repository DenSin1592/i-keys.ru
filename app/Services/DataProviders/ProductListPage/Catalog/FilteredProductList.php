<?php namespace App\Services\DataProviders\ProductListPage\Catalog;

use App\Models\Category;
use App\Services\DataProviders\ClientProductList\ClientProductList;
use App\Services\DataProviders\ProductListPage\FilterVariantsProvider;
use App\Services\Repositories\Product\EloquentProductRepository;

/**
 * Class FilteredProductList
 * @package App\Services\DataProviders\ProductListPage
 */
class FilteredProductList extends ProductListPageProvider
{
    private $productRepository;

    /**
     * FilteredProductList constructor.
     * @param EloquentProductRepository $productRepository
     * @param FilterVariantsProvider $filterVariantsProvider
     * @param ClientProductList $productListProvider
     * @param Category $category
     * @param array $filterData
     * @param $sort
     * @param $productsView
     */
    public function __construct(
        EloquentProductRepository $productRepository,
        FilterVariantsProvider $filterVariantsProvider,
        ClientProductList $productListProvider,
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

        $this->productRepository = $productRepository;
    }

    protected function getPaginator($page)
    {
        return \PrettyPaginator::makeFromCallback(
            function ($page, $limit) {
                return $this->productRepository->publishedInCategoryTreeByPage(
                    $this->category,
                    $page,
                    $limit,
                    $this->filterData,
                    $this->sort
                );
            },
            \UrlBuilder::getUrl($this->category),
            $page,
            self::ELEMENTS_ON_PAGE,
            [
                'filter' => $this->filterData,
                'sort' => $this->sort,
                'view' => $this->productsView,
            ]
        );
    }
}
