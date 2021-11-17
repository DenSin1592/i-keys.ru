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
use App\Services\Seo\MetaHelper;
use \Illuminate\Contracts\View\View;

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
        private Breadcrumbs $breadcrumbs
    ){}


    public function showCategory(string $categoryQuery) : View
    {
        $parsedQuery = $this->parseUrlQuery($categoryQuery);
        $page = $parsedQuery['page'];
        $aliasPath = $parsedQuery['aliasPath'];

        $category = $this->checkPathAndReturnCurrentCategory($aliasPath);

        $inputData = $this->prepareInputData();
        $productsView = \Helper::prepareProductsView(\Request::get('view'));

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
        $metaData = $this->metaHelper->getRule('category')->metaForObject($category, null, ['paginator' => \Arr::get($productListData, 'paginator')]);

        return \View::make('client.categories.show')
            ->with($productListData)
            ->with('breadcrumbs', $breadcrumbs)
            ->with('authEditLink', route('cc.categories.edit', $category->id))
            ->with($metaData);
    }


    private function checkPathAndReturnCurrentCategory(array $aliasPath): Category
    {
        $categories = $this->categoryRepository->getPublishedWithAliases($aliasPath);
        $parentCategory = null;
        foreach ($aliasPath as $alias) {
            $parentCategoryId = is_null($parentCategory) ? null : $parentCategory->id;
            $matchedCategory = null;

            foreach ($categories as $category) {
                if ($category->parent_id === $parentCategoryId && ($category->alias) === $alias) {
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
}
