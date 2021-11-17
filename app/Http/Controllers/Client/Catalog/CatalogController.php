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


    public function showCategory($categoryQuery = null)
    {
        $parsedQuery = $this->parseUrlQuery($categoryQuery);
        $page = $parsedQuery['page'];
        $aliasPath = $parsedQuery['aliasPath'];
        if (count($aliasPath) === 0) {
            \App::abort(404, 'Incorrect path to category');
        }

        $categoryPath = $this->getCategoryPath($aliasPath);
        if (count($aliasPath) !== count($categoryPath)) {
            \App::abort(404, 'Incorrect path to category');
        }

        $category = array_pop($categoryPath);
        if (is_null($category)) {
            \App::abort(404, 'Category is not found');
        }

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
        $authEditLink = route('cc.categories.edit', $category->id);

        return \View::make('client.categories.show')
            ->with($productListData)
            ->with('breadcrumbs', $breadcrumbs)
            ->with('authEditLink', $authEditLink)
            ->with('currentCategory', $category)
            ->with($metaData);
    }


    private function getCategoryPath(array $aliasPath): array
    {
        $categoryPath = [];
        $categories = $this->categoryRepository->getPublishedWithAliases($aliasPath);
        $parentCategory = null;
        foreach ($aliasPath as $alias) {
            $alias = mb_strtolower($alias);
            $parentCategoryId = is_null($parentCategory) ? null : $parentCategory->id;
            $matchedCategory = null;
            /** @var Category $category */
            foreach ($categories as $category) {
                if ($category->parent_id === $parentCategoryId && mb_strtolower($category->alias) === $alias) {
                    $matchedCategory = $category;
                    break;
                }
            }

            if ($matchedCategory === null) {
                \App::abort(404, "Wrong category path");
            }

            if ($parentCategory !== null) {
                $matchedCategory->parent()->associate($parentCategory);
            }
            $categoryPath[] = $matchedCategory;
            $parentCategory = $matchedCategory;
        }

        return $categoryPath;
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
