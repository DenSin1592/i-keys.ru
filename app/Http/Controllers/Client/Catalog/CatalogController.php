<?php

namespace App\Http\Controllers\Client\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Breadcrumbs\Factory as Breadcrumbs;
use App\Services\Catalog\ListSorting\SortingContainer;
use App\Services\DataProviders\ClientProductList\ClientProductList;
use App\Services\DataProviders\ProductListPage\Catalog\FilteredProductList;
use App\Services\DataProviders\ProductListPage\FilterVariantsProvider;
use App\Services\Repositories\Category\EloquentCategoryRepository;
use App\Services\Repositories\Product\EloquentProductRepository;
use App\Services\Repositories\ProductTypePage\EloquentProductTypePageRepository;
use App\Services\Seo\MetaHelper;
use \Illuminate\Contracts\View\View;
use \Illuminate\Http\JsonResponse;


class CatalogController extends Controller
{
    use CatalogBreadcrumbs;

    public function __construct(
        private EloquentCategoryRepository $categoryRepository,
        private EloquentProductRepository $productRepository,
        private FilterVariantsProvider $filterVariantsProvider,
        private ClientProductList $productListProvider,
        private MetaHelper $metaHelper,
        private Breadcrumbs $breadcrumbs,
        private EloquentProductTypePageRepository $typeProductRepository,
    ){}


    public function getResponse(Category $category, array $inputData): View|JsonResponse
    {
        $productListPageProvider = new FilteredProductList(
            $this->productRepository,
            $this->filterVariantsProvider,
            $this->productListProvider,
            $category,
            $inputData['filterData'] ?? [],
            $inputData['sort'] ?? \App::make(SortingContainer::class)->getDefaultSortingVariant(),
            $inputData['productsView'] ?? ''
        );

        $productListData = $productListPageProvider->getProductListData($inputData['page']);
        $breadcrumbs = $this->getBreadcrumbs($this->breadcrumbs, $category->extractPath());

        if (!\Request::ajax()) {
            return \View::make('client.categories.show')
                ->with($productListData)
                ->with('breadcrumbs', $breadcrumbs)
                ->with('authEditLink', route('cc.categories.edit', $category->id))
                ->with('metaData', $this->metaHelper->getRule()->metaForObject($category));
        }

        $contentData  = [
            'category' => $category,
            'filter' => $productListData['filter'],
            'sorting' => $inputData['sort'],
            'productsData' => $productListData['productsData'],
            'paginator' => $productListData['paginator'],
            'breadcrumbs' => $breadcrumbs,
        ];

        $categoryContent = \View::make('client.categories._category_content')
            ->with($contentData)->render();

        $filterContent = \View::make('client.categories._filter_block')->with([
            'category' => $contentData['category'],
            'filter' => $contentData['filter'],
            'sorting' => $contentData['sorting'],
        ])->render();

        $breadcrumbsContent = \View::make('client.shared.breadcrumbs._breadcrumbs_part')
            ->with('breadcrumbs', $contentData['breadcrumbs'])->render();

        return \Response::json([
            'categoryContent' => $categoryContent,
            'sorting' => $contentData['sorting'],
            'filterContent' => $filterContent,
            'breadcrumbsContent' => $breadcrumbsContent,
        ]);
    }
}
