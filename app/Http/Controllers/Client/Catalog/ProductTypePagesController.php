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
use App\Services\Catalog\ListSorting\SortingContainer;
use App\Services\DataProviders\ClientProductList\ClientProductList;
use App\Services\DataProviders\ProductListPage\FilterVariantsProvider;
use App\Services\DataProviders\ProductListPage\ProductTypePage\DefaultProductTypePageProductList;
use App\Services\DataProviders\ProductListPage\ProductTypePage\FilteredProductTypePageProductList;
use App\Services\DataProviders\ProductListPage\ProductTypePage\ManualProductTypePageProductList;
use App\Services\Repositories\Product\EloquentProductRepository;
use App\Services\Repositories\ProductTypePage\EloquentProductTypePageRepository;
use App\Services\Repositories\Service\EloquentServiceRepository;
use App\Services\Seo\MetaHelper;
use \Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Http\JsonResponse;


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


    public function showPage(string $url): View|JsonResponse
    {
        [$aliasPath, $inputData['page']] = $this->parseUrlQuery($url);
        $inputData['filterData'] = \Request::get('filter', []);
        $inputData['sort'] = \Request::get('sort', \App::make(SortingContainer::class)->getDefaultSortingVariant());
        $inputData['productsView'] = \Helper::prepareProductsView(\Request::get('view'));

        $productTypePage = $this->checkPathAndReturnCurrentTypePage($aliasPath);

        $productListPageProvider = match ($productTypePage->product_list_way){
            ProductTypePage::WAY_FILTERED => $this->getFilteredProductDataProvider(
                $productTypePage,
                $inputData['sort'],
                $inputData['productsView'],
            ),
            ProductTypePage::WAY_MANUAL => new ManualProductTypePageProductList(
                $this->productRepository,
                $this->filterVariantsProvider,
                $this->productListProvider,
                $productTypePage,
                $productTypePage->category,
                $inputData['sort'],
                $inputData['productsView'],
            ),
        };

        $productListData = $productListPageProvider->getProductListData($inputData['page']);
        $metaData = $this->metaHelper->getRule()->metaForObject($productTypePage);
        $breadcrumbs = $this->getBreadcrumbsForCategories($this->breadcrumbs, $productTypePage->extractPath());
        $linksTypesContent = $productTypePage->content_for_links_type;
        $services = resolve(EloquentServiceRepository::class)->getACertainNumberOfModels(3);


        if (!\Request::ajax()) {
            return \View::make('client.categories.show')
                ->with($productListData)
                ->with('topContent', $productTypePage->content)
                ->with('bottomContent', $productTypePage->bottom_content)
                ->with('breadcrumbs', $breadcrumbs)
                ->with('authEditLink', route('cc.product-type-pages.edit', $productTypePage->id))
                ->with('metaData', $metaData)
                ->with('linksTypesContent', $linksTypesContent)
                ->with('rootCategory', $productTypePage->category_id)
                ->with('services', $services)
                ->with('productTypePage', $productTypePage)
                ;
        }

        $contentData  = [
            'productTypePage' => $productTypePage,
            'category' => $productListData['category'],
            'topContent' => $productTypePage->content,
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


    private function checkPathAndReturnCurrentTypePage(array $aliasPath): ?ProductTypePage
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


    private function getFilteredProductDataProvider(ProductTypePage $productTypePage, $inputSort, $productsView): FilteredProductTypePageProductList|DefaultProductTypePageProductList
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
        } catch (IncorrectFilterUrl $ex) {

            $productListPageProvider = new DefaultProductTypePageProductList(
                $this->filterVariantsProvider,
                $this->productListProvider,
                $productTypePage,
                new Category(),
                [],
                'price_asc',
                $productsView);
        }

        return $productListPageProvider;
    }
}
