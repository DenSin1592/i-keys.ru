<?php

namespace App\Http\Controllers\Client\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Breadcrumbs\Factory as Breadcrumbs;
use App\Services\Catalog\ListSorting\SortingContainer;
use App\Services\DataProviders\ClientProductList\ClientProductList;
use App\Services\DataProviders\ProductListPage\Catalog\FilteredProductList;
use App\Services\DataProviders\ProductListPage\FilterVariantsProvider;
use App\Services\Repositories\Product\EloquentProductRepository;
use App\Services\Seo\MetaHelper;
use \Illuminate\Contracts\View\View;
use \Illuminate\Http\JsonResponse;


class CatalogController extends Controller
{
    use CatalogBreadcrumbs;

    public function __construct(
        private EloquentProductRepository $productRepository,
        private FilterVariantsProvider $filterVariantsProvider,
        private ClientProductList $productListProvider,
        private MetaHelper $metaHelper,
        private Breadcrumbs $breadcrumbs,
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
        $breadcrumbs = $this->getBreadcrumbsForCategories($this->breadcrumbs, $category->extractPath());
        $metaData = $this->metaHelper->getRule()->metaForObject($category);
        $linksTypesContent = $category->content_for_links_type;

        if (!\Request::ajax()) {
            return \View::make('client.categories.show')
                ->with($productListData)
                ->with('topContent', $category->top_content)
                ->with('breadcrumbs', $breadcrumbs)
                ->with('authEditLink', route('cc.categories.edit', $category->id))
                ->with('metaData', $metaData)
                ->with('linksTypesContent', $linksTypesContent);
        }

        $contentData  = [
            'category' => $category,
            'topContent' => $category->top_content,
            'filter' => $productListData['filter'],
            'sorting' => $inputData['sort'],
            'productsData' => $productListData['productsData'],
            'paginator' => $productListData['paginator'],
            'breadcrumbs' => $breadcrumbs,
            'linksTypesContent' => $linksTypesContent,
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
            'h1' => $metaData['h1'],
        ]);
    }


    public function getNewProductCard(ClientProductList $productListProvider): JsonResponse
    {
        $data = \Request::all();
        $product = $this->productRepository->findById($data['productId']);
        $productData = $productListProvider->getProductListData([$product])[0];

        $content = \View::make('client.categories._products_grid._product_card', [
            'productData' => $productData,
            'cardNumber' => $data['cardNumber'],
        ])->render();

        return \Response::json([
            'content' => $content,
        ]);
    }
}
