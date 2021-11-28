<?php

namespace App\Http\Controllers\Client\Catalog;

use App\Http\Controllers\Client\Features\UrlQueryParser;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Breadcrumbs\Factory as Breadcrumbs;
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
    use UrlQueryParser;


    public function __construct(
        private EloquentCategoryRepository $categoryRepository,
        private EloquentProductRepository $productRepository,
        private FilterVariantsProvider $filterVariantsProvider,
        private ClientProductList $productListProvider,
        private MetaHelper $metaHelper,
        private Breadcrumbs $breadcrumbs,
        private EloquentProductTypePageRepository $typeProductRepository,
    ){}


    public function showCategory(string $categoryQuery): View|JsonResponse
    {
        [$page, $aliasPath] = $this->parseUrlQuery($categoryQuery);
        $productsView = \Helper::prepareProductsView(\Request::get('view'));

        $category = $this->checkPathAndReturnCurrentCategory($aliasPath);
        $inputData = $this->prepareInputData();

        $productListPageProvider = new FilteredProductList(
            $this->productRepository,
            $this->filterVariantsProvider,
            $this->productListProvider,
            $category,
            $inputData['filterData'],
            $inputData['sort'],
            $productsView
        );

        $productListData = $productListPageProvider->getProductListData($page);
        $breadcrumbs = $this->getBreadcrumbs($this->breadcrumbs, $category->extractPath());

        if (!\Request::ajax()) {
            return \View::make('client.categories.show')
                ->with($productListData)
                ->with('breadcrumbs', $breadcrumbs)
                ->with('authEditLink', route('cc.categories.edit', $category->id))
                ->with('listTypeProducts', $this->getListTypePageUrl($category->id))
                ->with('metaData', $this->metaHelper->getRule()->metaForObject($category));
        }

        $contentData  = [
            'category' => $category,
            'filter' => $productListData['filter'],
            'sorting' => $inputData['sort'],
            'productsData' => $productListData['productsData'],
            'bottomContent' => $category->bottom_content,
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





    private function checkPathAndReturnCurrentCategory(array $aliasPath): Category
    {
        $categories = $this->categoryRepository->getPublishedWithAliases($aliasPath);
        $parentCategory = null;
        foreach ($aliasPath as $alias) {
            $parentCategoryId = is_null($parentCategory) ? null : $parentCategory->id;
            $matchedCategory = null;

            foreach ($categories as $category) {
                if ($category->parent_id === $parentCategoryId && $category->alias === $alias) {
                    $matchedCategory = $category;
                    break;
                }
            }
            if ($matchedCategory === null) {
                \App::abort(404, "Wrong category path");
            }
            $parentCategory = $matchedCategory;
        }

        return $matchedCategory;
    }


    private function prepareInputData()
    {
        $filterData = \Request::get('filter', []);
        if (!is_array($filterData)) {
            $filterData = [];
        }

        $sort = \Request::get('sort');
        if (!is_string($sort)) {
            $sort = null;
        }

        return [
            'filterData' => $filterData,
            'sort' => $sort,
        ];
    }


    private function getListTypePageUrl($categoryId): array
    {
        $listTypeProducts = $this->typeProductRepository->getModelsByCategoryId($categoryId);
        $list = [];

        foreach ($listTypeProducts as $type) {
            $list[$type->name] = \UrlBuilder::buildTypeUrl($type);
        }

        return $list;
    }
}
