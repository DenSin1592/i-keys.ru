<?php

namespace App\Http\Controllers\Client\Catalog;

use App\Exceptions\Handler;
use App\Http\Controllers\Client\Features\UrlQueryParser;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductTypePage;
use App\Services\Breadcrumbs\Factory as Breadcrumbs;
use App\Services\Catalog\FilterUrlParser\Exception\IncorrectFilterUrl;
use App\Services\Catalog\FilterUrlParser\Exception\UnpublishedCategory;
use App\Services\Catalog\FilterUrlParser\FilterUrlParser;
use App\Services\DataProviders\ClientProductList\ClientProductList;
use App\Services\DataProviders\ProductListPage\FilterVariantsProvider;
use App\Services\DataProviders\ProductListPage\ProductTypePage\DefaultProductTypePageProductList;
use App\Services\DataProviders\ProductListPage\ProductTypePage\FilteredProductTypePageProductList;
use App\Services\DataProviders\ProductListPage\ProductTypePage\ManualProductTypePageProductList;
use App\Services\Repositories\Product\EloquentProductRepository;
use App\Services\Repositories\ProductTypePage\EloquentProductTypePageRepository;
use App\Services\Seo\MetaHelper;


class ProductTypePagesController extends Controller
{
    use CatalogBreadcrumbs;
    use UrlQueryParser;


    public function __construct(
        private EloquentProductTypePageRepository $productTypePageRepository,
        private EloquentProductRepository $productRepository,
        private FilterVariantsProvider $filterVariantsProvider,
        private ClientProductList $productListProvider,
        private FilterUrlParser $filterUrlParser,
        private MetaHelper $metaHelper,
        private Breadcrumbs $breadcrumbs,
    ){}


    public function showPage(string $pageQuery)
    {
        [$page, $aliasPath] = $this->parseUrlQuery($pageQuery);
        $productsView = \Helper::prepareProductsView(\Request::get('view'));
        $sortInput = is_string(\Request::get('sort'))? \Request::get('sort'): null;

        $productTypePage = $this->checkPathAndReturnCurrentTypePage($aliasPath);

        $productListPageProvider = match ($productTypePage->product_list_way){
            ProductTypePage::WAY_FILTERED => $this->getFilteredProductDataProvider(
                $productTypePage,
                $sortInput,
                $productsView
            ),
            ProductTypePage::WAY_MANUAL => new ManualProductTypePageProductList(
                $this->productRepository,
                $this->filterVariantsProvider,
                $this->productListProvider,
                $productTypePage,
                $productTypePage->category,
                $sortInput,
                $productsView
            ),
        };


        $productListData = $productListPageProvider->getProductListData($page);
        $metaData = $this->metaHelper->getRule('product_type_page')
            ->metaForObject($productTypePage, null, ['paginator' => \Arr::get($productListData, 'paginator')]);

//        if (\Request::ajax()) {
//            $contentData = [
//                'category' => $productListData['category'],
//                'filter' => $productListData['filter'],
//                'filterVariants' => $productListData['filter']['filterVariants'],
//                'sortingVariants' => $productListData['filter']['sortingVariants'],
//                'productsData' => $productListData['productsData'],
//                'authEditLink' => route('cc.product-type-pages.edit', [$productTypePage->id]),
//                'paginator' => $productListData['paginator'],
//                'breadcrumbs' => $breadcrumbs,
//            ];
//
//            $filterExpanded = \Request::get('filterExpanded') === true ||
//                \Request::get('filterExpanded') === 'true';
//            $filterExpandedParams = \Request::get('filterExpandedParams');
//            if (!is_array($filterExpandedParams)) {
//                $filterExpandedParams = [];
//            }
//            $categoryContent = view('client.categories._category_content')
//                ->with($contentData)->render();
//            $filterContent = view('client.categories._filter_block')->with([
//                'category' => $contentData['category'],
//                'filter' => $contentData['filter'],
//                'filterExpanded' => $filterExpanded,
//                'filterExpandedParams' => $filterExpandedParams,
//            ])->render();
//            $breadcrumbsContent = view('client.layouts._breadcrumbs_part')
//                ->with('breadcrumbs', $contentData['breadcrumbs'])->render();
//            return response()->json([
//                'category' => $contentData['category'],
//                'categoryContent' => $categoryContent,
//                'filterContent' => $filterContent,
//                'authEditLink' => $contentData['authEditLink'],
//                'breadcrumbsContent' => $breadcrumbsContent,
//            ]);
//        }

        return \View::make('client.categories.show')
            ->with($productListData)
            ->with([
                    'listTypeProducts' => $this->getListTypePageUrl($productTypePage->category_id),
                    'authEditLink' => route('cc.product-type-pages.edit', [$productTypePage->id]),
                    'breadcrumbs' => $this->getBreadcrumbs($this->breadcrumbs, $productTypePage->extractPath()),
                    'metaData' => $metaData,
                ]);

    }


    private function checkPathAndReturnCurrentTypePage(array $aliasPath): ProductTypePage
    {
        $typePages = $this->productTypePageRepository->getPublishedWithAliases($aliasPath);
        $parentPage = null;
        foreach ($aliasPath as $alias) {
            $parentPageId = is_null($parentPage) ? null : $parentPage->id;
            $matchedPage = null;

            foreach ($typePages as $page) {
                if ($page->parent_id === $parentPageId && $page->alias === $alias) {
                    $matchedPage = $page;
                    break;
                }
            }
            if ($matchedPage === null) {
                \App::abort(404, "Wrong type path");
            }
            $parentPage = $matchedPage;
        }

        return $matchedPage;
    }


    private function getFilteredProductDataProvider(ProductTypePage $productTypePage, $inputSort, $productsView)
    {
        try {
            $parsedFilterString = $this->filterUrlParser->parseFilterUrl($productTypePage->filter_query ?? '');
            /** @var Category|null $category */
            $category = $parsedFilterString['category'];
            if (!$category->in_tree_publish) {
                throw new UnpublishedCategory("Category {$category->name} is not published.");
            }
            $filterData = $parsedFilterString['filterData'];
            $pageSort = $parsedFilterString['sort'];

            $sort = !is_null($inputSort) ? $inputSort : $pageSort;
            $productListPageProvider = new FilteredProductTypePageProductList(
                $this->productRepository,
                $this->filterVariantsProvider,
                $this->productListProvider,
                $productTypePage,
                $category,
                $filterData,
                $sort,
                $productsView
            );
        } catch (IncorrectFilterUrl $e) {
            resolve(Handler::class)->report($e);
            \App::abort(404, 'Incorrect path to category');
        }

        return $productListPageProvider;
    }


    private function getListTypePageUrl($categoryId): array
    {
        $listTypeProducts = $this->productTypePageRepository->getModelsByCategoryId($categoryId);
        $list = [];

        foreach ($listTypeProducts as $type) {
            $list[$type->name] = \UrlBuilder::buildTypeUrl($type);
        }

        return $list;
    }
}
