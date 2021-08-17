<?php namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Services\DataProviders\AssociatedProductsForm\AssociatedProductsForm;
use App\Services\Repositories\Category\EloquentCategoryRepository;
use App\Services\Repositories\Product\EloquentProductRepository;
use Illuminate\Http\JsonResponse;
use Request;


class AssociatedProductsController extends Controller
{
    private $associatedProductsForm;
    private $productRepository;
    private $categoryRepository;

    public function __construct(
        AssociatedProductsForm $associatedProductsForm,
        EloquentProductRepository $productRepository,
        EloquentCategoryRepository $categoryRepository
    ) {
        $this->associatedProductsForm = $associatedProductsForm;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param $fieldGroup
     * @param null $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function availableProducts($fieldGroup, $productId = null): JsonResponse
    {
        if (!Request::ajax()) {
            \App::abort(404, 'Page is not found');
        }

        $selectedProductIds = Request::get('selectedProductIds');
        if (!is_array($selectedProductIds)) {
            $selectedProductIds = [];
        }

        $groupedProducts = $this->productRepository->groupedForRootCategories($productId);
        $selectedProducts = $this->productRepository->sortedByIds($selectedProductIds);

        $availableContent = \View::make(
            'admin.shared.popup_associated_products._available_products',
            [
                'fieldGroup' => $fieldGroup,
                'groupedProducts' => $groupedProducts,
                'productId' => $productId,
                'selectedProductIds' => $selectedProductIds
            ]
        )->render();

        $selectedContent = \View::make(
            'admin.shared.popup_associated_products._selected_product_list',
            ['products' => $selectedProducts]
        )->render();

        return \Response::json(
            [
                'available_content' => $availableContent,
                'selected_content' => $selectedContent,
            ]
        );
    }

    /**
     * @param $fieldGroup
     * @return JsonResponse
     */
    public function newAssociations($fieldGroup): JsonResponse
    {
        if (!Request::ajax()) {
            \App::abort(404, 'Page is not found');
        }

        $productsData = Request::get('products');
        if (!is_array($productsData)) {
            $productsData = [];
        }

        $associatedProducts = $this->associatedProductsForm->buildForProductsData($productsData);
        $content = \View::make(
            'admin.shared.popup_associated_products._current_products',
            ['fieldGroup' => $fieldGroup, 'associatedProducts' => $associatedProducts]
        )->render();

        return \Response::json(['content' => $content]);
    }

    /**
     * @param null $productId
     * @return JsonResponse
     */
    public function filterAvailable($productId = null): JsonResponse
    {
        if (!Request::ajax()) {
            \App::abort(404, 'Page is not found');
        }

        $query = Request::get('query');
        if (!is_string($query)) {
            $query = '';
        } else {
            $query = trim($query);
        }
        $categoryId = Request::get('categoryId');
        $selectedProductIds = Request::get('selectedProductIds');
        if (!is_array($selectedProductIds)) {
            $selectedProductIds = [];
        }

        $category = $this->categoryRepository->findById($categoryId);
        if (null === $category) {
            \App::abort(404, 'Category is not found');
        }

        $products = $this->productRepository->filterByNameAndCode1cInCategory($query, $categoryId, $productId);

        $content = \View::make(
            'admin.shared.popup_associated_products._available_product_list',
            ['products' => $products, 'selectedProductIds' => $selectedProductIds]
        )->render();

        return \Response::json(['content' => $content]);
    }

    public function filterSelected(): JsonResponse
    {
        if (!Request::ajax()) {
            \App::abort(404, 'Page is not found');
        }

        $query = Request::get('query');
        if (!is_string($query)) {
            $query = '';
        }
        $selectedProductIds = Request::get('selectedProductIds');
        if (!is_array($selectedProductIds)) {
            $selectedProductIds = [];
        }
        $products = $this->productRepository->filterByNameAndCode1cAmongProducts($query, $selectedProductIds);

        $content = \View::make(
            'admin.shared.popup_associated_products._selected_product_list',
            ['products' => $products]
        )->render();

        return \Response::json(['content' => $content]);
    }
}
