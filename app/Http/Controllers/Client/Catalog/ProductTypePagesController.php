<?php

namespace App\Http\Controllers\Client\Catalog;

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
//        private EloquentCategoryRepository $categoryRepository,
        private EloquentProductRepository $productRepository,
        private FilterVariantsProvider $filterVariantsProvider,
        private ClientProductList $productListProvider,
        private FilterUrlParser $filterUrlParser,
        private MetaHelper $metaHelper,
        private Breadcrumbs $breadcrumbs,
    ) {}

    public function showPage(string $pageQuery)
    {
        $parsedQuery = $this->parseUrlQuery($pageQuery);
        $page = $parsedQuery['page'];
        $aliasPath = $parsedQuery['aliasPath'];
        if (count($aliasPath) === 0) {
            \App::abort(404, 'Incorrect path to product type page');
        }

        $pagePath = $this->getProductTypePagePath($aliasPath);
        if (count($aliasPath) !== count($pagePath)) {
            \App::abort(404, 'Incorrect path to product type page');
        }

        $productTypePage = array_pop($pagePath);
        if (is_null($productTypePage)) {
            \App::abort(404, 'Product type page is not found');
        }
        $parent = array_pop($pagePath);
        // associate model with last category in order not to do same queries later
        if (!is_null($parent)) {
            $productTypePage->parent()->associate($parent);
        }

        $breadcrumbs = $this->getBreadcrumbsFor($productTypePage);

        $sortInput = \Request::get('sort');
        if (!is_string($sortInput)) {
            $sortInput = null;
        }
        $productsView = \Helper::prepareProductsView(\Request::get('view'));

        // Get data provider
        if ($productTypePage->product_list_way === ProductTypePage::WAY_FILTERED) {
            $productListPageProvider = $this->getFilteredProductDataProvider(
                $productTypePage,
                $sortInput,
                $productsView
            );

        } elseif ($productTypePage->product_list_way === ProductTypePage::WAY_MANUAL) {
            $category = $productTypePage->category;
            if (is_null($category)) {
                $category = $this->categoryRepository->newInstance();
            }

            $productListPageProvider = new ManualProductTypePageProductList(
                $this->productRepository,
                $this->filterVariantsProvider,
                $this->productListProvider,
                $productTypePage,
                $category,
                $sortInput,
                $productsView
            );
        } else {
            $category = $this->categoryRepository->newInstance();

            $productListPageProvider = new DefaultProductTypePageProductList(
                $this->filterVariantsProvider,
                $this->productListProvider,
                $productTypePage,
                $category,
                [],
                $sortInput,
                $productsView
            );
        }

        $productListData = $productListPageProvider->getProductListData($page);
        $metaData = $this->metaHelper->getRule('product_type_page')
            ->metaForObject($productTypePage, null, ['paginator' => \Arr::get($productListData, 'paginator')]);

        if (\Request::ajax()) {
            $contentData = [
                'category' => $productListData['category'],
                'filter' => $productListData['filter'],
                'filterVariants' => $productListData['filter']['filterVariants'],
                'sortingVariants' => $productListData['filter']['sortingVariants'],
                'productsData' => $productListData['productsData'],
                'authEditLink' => route('cc.product-type-pages.edit', [$productTypePage->id]),
                'paginator' => $productListData['paginator'],
                'breadcrumbs' => $breadcrumbs,
            ];

            $filterExpanded = \Request::get('filterExpanded') === true ||
                \Request::get('filterExpanded') === 'true';
            $filterExpandedParams = \Request::get('filterExpandedParams');
            if (!is_array($filterExpandedParams)) {
                $filterExpandedParams = [];
            }
            $categoryContent = view('client.categories._category_content')
                ->with($contentData)->render();
            $filterContent = view('client.categories._filter_block')->with([
                'category' => $contentData['category'],
                'filter' => $contentData['filter'],
                'filterExpanded' => $filterExpanded,
                'filterExpandedParams' => $filterExpandedParams,
            ])->render();
            $breadcrumbsContent = view('client.layouts._breadcrumbs_part')
                ->with('breadcrumbs', $contentData['breadcrumbs'])->render();
            return response()->json([
                'category' => $contentData['category'],
                'categoryContent' => $categoryContent,
                'filterContent' => $filterContent,
                'authEditLink' => $contentData['authEditLink'],
                'breadcrumbsContent' => $breadcrumbsContent,
            ]);
        } else {

            return \View::make('client.categories.show')
//                ->with(compact('productTypePage'))
                ->with($productListData,)
                ->with([
                    'listTypeProducts' => $this->getListTypePageUrl($productTypePage->category_id),
                    'authEditLink' => route('cc.product-type-pages.edit', [$productTypePage->id]),
                    'breadcrumbs' => $breadcrumbs,
                    'metaData' => $metaData,
                ]);
        }
    }

    /**
     * @param ProductTypePage $productTypePage
     * @param $inputSort
     * @param $productsView
     * @return DefaultProductTypePageProductList|FilteredProductTypePageProductList
     */
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
            $category = $this->categoryRepository->newInstance();

            $productListPageProvider = new DefaultProductTypePageProductList(
                $this->filterVariantsProvider,
                $this->productListProvider,
                $productTypePage,
                $category,
                [],
                $inputSort,
                $productsView
            );
        }

        return $productListPageProvider;
    }


    /**
     * Get product type page path.
     *
     * @param array $aliasPath
     * @return array
     */
    private function getProductTypePagePath(array $aliasPath)
    {
        $pagePath = [];
        $categories = $this->productTypePageRepository->getPublishedWithAliases($aliasPath);
        $parentPage = null;
        foreach ($aliasPath as $alias) {
            $alias = mb_strtolower($alias);
            $parentPageId = is_null($parentPage) ? null : $parentPage->id;
            $matchedPage = null;
            /** @var ProductTypePage $page */
            foreach ($categories as $page) {
                if ($page->parent_id === $parentPageId && mb_strtolower($page->alias) === $alias) {
                    $matchedPage = $page;
                    break;
                }
            }

            if ($matchedPage === null) {
                \App::abort(404, "Wrong category path");
            } else {
                if ($parentPage !== null) {
                    $matchedPage->parent()->associate($parentPage);
                }
                $pagePath[] = $matchedPage;
                $parentPage = $matchedPage;
            }
        }

        return $pagePath;
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


    private function getBreadcrumbsFor(ProductTypePage $productTypePage)
    {
        $breadcrumbs = $this->breadcrumbs->init();
        $breadcrumbs->add('Главная', route('home'));
        $pagesPath = $productTypePage->extractPath();
        foreach ($pagesPath as $page) {
            $breadcrumbs->add(
                $page->name,
                \UrlBuilder::getUrl($page)
            );
        }

        return $breadcrumbs;
    }
}
