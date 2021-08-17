<?php

namespace App\Http\Controllers\Admin\ProductTypePages;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\DataProviders\ProductTypePageForm\ProductTypePageForm;
use App\Services\Repositories\Category\EloquentCategoryRepository;
use App\Services\Repositories\Product\EloquentProductRepository;
use App\Services\Repositories\ProductTypePage\EloquentProductTypePageRepository;
use App\Services\Repositories\ProductTypePageAssociation\EloquentProductTypePageAssociationRepository;
use Illuminate\Http\JsonResponse;

class Products extends Controller
{
    private $productTypePageRepository;
    private $productTypePageAssociationRepository;
    private $categoryRepository;
    private $productRepository;
    private $formProvider;

    public function __construct(
        EloquentProductTypePageRepository $productTypePageRepository,
        EloquentProductTypePageAssociationRepository $productTypePageAssociationRepository,
        EloquentCategoryRepository $categoryRepository,
        EloquentProductRepository $productRepository,
        ProductTypePageForm $formProvider
    ) {
        $this->productTypePageRepository = $productTypePageRepository;
        $this->productTypePageAssociationRepository = $productTypePageAssociationRepository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->formProvider = $formProvider;
    }

    public function getFilteredProducts($productTypePageId = null)
    {
        if (!\Request::ajax()) {
            \App::abort(404, 'Page is not found');
        }

        $productTypePage = $this->productTypePageRepository->findOrNew($productTypePageId);
        $filteredProducts = $this->formProvider->getProductsByFilterUrl(
            $productTypePage,
            (string)\Request::get('filter_query')
        );
        $filteredData = [
            'products' => $filteredProducts,
            'associations' => [],
        ];

        return \View::make(
            'admin.product_type_pages.products._filtered_products',
            ['productTypePage' => $productTypePage, 'filteredData' => $filteredData]
        );
    }

    public function getAssociationBlock($productId, $associationType, $pageId = null)
    {
        if (!\Request::ajax()) {
            \App::abort(404, 'Page is not found');
        }

        /** @var Product $product */
        $product = $this->productRepository->findById($productId);
        if (is_null($product)) {
            \App::abort(404, 'Product not found');
        }

        $productTypePage = $this->productTypePageRepository->findOrNew($pageId);
        $association = $this->productTypePageAssociationRepository->findOrNewForPageAndProduct(
            $productTypePage,
            $product
        );

        return \View::make('admin.product_type_pages.products._association_block')
            ->with('association', $association)
            ->with('associationType', $associationType)
            ->with('associationOpened', true);
    }

    public function getManualTree($productTypePageId = null): JsonResponse
    {
        if (!\Request::ajax()) {
            \App::abort(404, 'Page is not found');
        }

        $productTypePage = $this->productTypePageRepository->findOrNew($productTypePageId);
        $manualData = $this->formProvider->provideDataForManualTree($productTypePage, \Request::old());

        $content = \View::make(
            'admin.product_type_pages.products._manual_root',
            ['productTypePage' => $productTypePage, 'manualData' => $manualData]
        )->render();

        return \Response::json(['catalog_tree_content' => $content]);
    }

    public function getManualSubTree($categoryId, $productTypePageId = null): JsonResponse
    {
        if (!\Request::ajax()) {
            \App::abort(404, 'Page is not found');
        }

        /** @var Category $category */
        $category = $this->categoryRepository->findById($categoryId);
        if (is_null($category)) {
            \App::abort(404, 'Category not found');
        }
        $productTypePage = $this->productTypePageRepository->findOrNew($productTypePageId);
        $manualData = $this->formProvider
            ->provideDataForManualSubTree($productTypePage, $category);

        $content = \View::make('admin.product_type_pages.products._manual_category_sub_tree')
            ->with('category', $category)
            ->with('productTypePage', $productTypePage)
            ->with('manualData', $manualData)
            ->render();

        return \Response::json(['catalog_sub_tree_content' => $content]);
    }
}