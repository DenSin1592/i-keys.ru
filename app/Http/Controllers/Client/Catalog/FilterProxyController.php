<?php

namespace App\Http\Controllers\Client\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductTypePage;
use App\Services\Catalog\FilterUrlParser\Exception\IncorrectFilterUrl;
use App\Services\Catalog\FilterUrlParser\FilterUrlParser;
use App\Services\Repositories\Category\EloquentCategoryRepository;
use App\Services\Repositories\Product\EloquentProductRepository;
use App\Services\Repositories\ProductTypePage\EloquentProductTypePageRepository;


class FilterProxyController extends Controller
{
    private Category $category;
    private array $filterInput;
    private ?string $sortInput;
    private string $productsView;
    private ?string $productTypePageId;


    public function __construct(
        private EloquentCategoryRepository $categoryRepository,
        private EloquentProductRepository $productRepository,
        private EloquentProductTypePageRepository $productTypePageRepository,
        private FilterUrlParser $filterUrlParser
    ){}


    public function redirectToFilterUrl()
    {

        $categoryId = (int)(\Request::get('category') ?? \App::abort(404, 'Category is not found'));
        $this->category = ($this->categoryRepository->findPublishedById($categoryId));
        $this->filterInput = is_array(\Request::get('filter')) ? \Request::get('filter') : [];
        $this->filterInput = $this->productRepository->clearFilterVariants($this->category, $this->filterInput);
        $this->sortInput = !is_string(\Request::get('sort')) ? \Request::get('sort') : null;
        $this->productsView = \Helper::prepareProductsView(\Request::get('view'));
        $this->productTypePageId = \Request::get('product_type_page');

        $targetUrl = $this->getProductTypePageUrl();

        if (is_null($targetUrl)) {
            $targetUrl = $this->getTypePageUrlForFilter();
        }

        if (is_null($targetUrl)) {
            $targetUrl = $this->getFilterUrl();
        }

        $url = \Helper::urlWithProductsView($targetUrl, $this->productsView);
        /*if (\Request::ajax()) {
            return ['url' => $url];
        } */
        return \Redirect::to($url, 301);


//        return \Redirect::to(\Helper::urlWithProductsView($targetUrl, $productsView), 301);
    }


    private function getProductTypePageUrl(): ?string
    {
        if (is_null($this->productTypePageId)) {
            return null;
        }

        $productTypePage = $this->productTypePageRepository->findPublishedById($this->productTypePageId);
        if (is_null($productTypePage)) {
            return null;
        }

        $targetUrl = null;
        switch ($productTypePage->product_list_way) {
            case ProductTypePage::WAY_FILTERED:
                try {
                    $pageQueryData = $this->filterUrlParser->parseFilterUrl($productTypePage->filter_query ?? '');
                    $productTypeCategory = $pageQueryData['category'];
                    $productTypeFilterData = $pageQueryData['filterData'];
                    $productTypeSort = $pageQueryData['sort'];
                } catch (IncorrectFilterUrl $e) {
                    break;
                }

                if ($productTypeCategory->id !== $this->category->id) {
                    break;
                }

                $sameQuery = $this->productRepository->compareFilterData(
                    $this->category,
                    $this->filterInput,
                    $productTypeFilterData
                );
                if ($sameQuery) {
                    $targetUrl = \Helper::urlWithHttpQuery(
                        \UrlBuilder::getUrl($productTypePage),
                        [
                            'sort' => ($productTypeSort == $this->sortInput ? null : $this->sortInput),
                        ]
                    );
                }
                break;
            case ProductTypePage::WAY_MANUAL:
                if (count($this->filterInput) > 0) {
                    break;
                }
                $productTypeCategory = $productTypePage->category;
                if (is_null($productTypeCategory) || $productTypeCategory->id !== $this->category->id) {
                    break;
                }

                $targetUrl = \Helper::urlWithHttpQuery(
                    \UrlBuilder::getUrl($productTypePage),
                    ['sort' => $this->sortInput]
                );

                break;
            default:
                break;
        }

        return $targetUrl;
    }


    private function getTypePageUrlForFilter()
    {
        $targetUrl = null;
        $defaultSortingVariant = $this->productRepository->getDefaultSortingVariant();

        $pageList = $this->productTypePageRepository->allPublishedWithFilter();
        foreach ($pageList as $page) {
            try {
                $parsedFilterString = $this->filterUrlParser->parseFilterUrl($page->filter_query);
                $productTypeCategory = $parsedFilterString['category'];
                $productTypeFilterData = $parsedFilterString['filterData'];
                $productTypeSort = $parsedFilterString['sort'];
            } catch (IncorrectFilterUrl $e) {
                continue;
            }
            if ($productTypeCategory->id !== $this->category->id) {
                continue;
            }

            if (($productTypeSort == $this->sortInput ||
                    (empty($productTypeSort) && $this->sortInput == $defaultSortingVariant) ||
                    (empty($this->sortInput) && $productTypeSort == $defaultSortingVariant)
                )
                && $this->productRepository->compareFilterData(
                    $this->category,
                    $this->filterInput,
                    $productTypeFilterData
                )
            ) {
                $targetUrl = \UrlBuilder::getUrl($page);
                break;
            }
        }
        return $targetUrl;
    }

    public function getFilterUrl()
    {
        $targetUrl = \Helper::urlWithHttpQuery(
            \UrlBuilder::getUrl($this->category),
            ['sort' => $this->sortInput, 'filter' => $this->filterInput]
        );

        return $targetUrl;
    }
}
