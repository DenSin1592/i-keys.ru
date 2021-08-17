<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Features\ToggleFlags;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Admin\Breadcrumbs\Breadcrumbs;
use App\Services\DataProviders\ProductForm\ProductForm;
use App\Services\FormProcessors\Product\ProductFormProcessor;
use App\Services\Pagination\FlexPaginator;
use App\Services\Repositories\Category\EloquentCategoryRepository;
use App\Services\Repositories\Product\EloquentProductRepository;

class ProductsController extends Controller
{
    use ToggleFlags;

    private $categoryRepository;
    private $productRepository;
    private $formDataProvider;
    private $formProcessor;
    private $breadcrumbs;
    private $flexPaginator;

    public function __construct(
        EloquentCategoryRepository $categoryRepository,
        EloquentProductRepository $productRepository,
        ProductForm $formDataProvider,
        ProductFormProcessor $formProcessor,
        Breadcrumbs $breadcrumbs,
        FlexPaginator $flexPaginator
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->formDataProvider = $formDataProvider;
        $this->formProcessor = $formProcessor;
        $this->breadcrumbs = $breadcrumbs;
        $this->flexPaginator = $flexPaginator;
    }


    public function index($categoryId)
    {
        $category = $this->getCategory($categoryId);
        $categoryTree = $this->categoryRepository->getCollapsedTree($category);

        $productList = $this->flexPaginator->make(
            function ($page, $limit) use ($categoryId) {
                return $this->productRepository->allInCategoryByPage($categoryId, $page, $limit);
            },
            "product-pagination-page-{$categoryId}",
            'product-pagination-limit'
        );

        $breadcrumbs = $this->breadcrumbs->getFor('category.products', $category);

        if (\Request::ajax()) {
            $content = \View::make('admin.categories._product_list')
                ->with('productList', $productList)->with('lvl', 0)
                ->render();

            return \Response::json(['element_list' => $content]);

        } else {
            return \View::make('admin.products.index')
                ->with('breadcrumbs', $breadcrumbs)
                ->with('category', $category)
                ->with('categoryTree', $categoryTree)
                ->with('productList', $productList);
        }
    }

    public function create($categoryId)
    {
        $category = $this->getCategory($categoryId);
        $product = $this->productRepository->newInstanceWithCategory($category);
        $productList = $this->getProductList($category);
        $formData = $this->formDataProvider->provideDataFor($product, \Request::old());
        $breadcrumbs = $this->breadcrumbs->getFor('category.product.create', $product);

        return \View::make('admin.products.create')
            ->with('breadcrumbs', $breadcrumbs)
            ->with('category', $category)
            ->with('product', $product)
            ->with('productList', $productList)
            ->with('formData', $formData);
    }

    private function getProductList(Category $category)
    {
        return $this->flexPaginator->make(
            function ($page, $limit) use ($category) {
                return $this->productRepository->allInCategoryByPage($category->id, $page, $limit);
            },
            "product-pagination-page-{$category->id}",
            'product-pagination-limit'
        );
    }

    public function updatePositions($categoryId)
    {
        $this->getCategory($categoryId);
        $this->productRepository->updatePositions(\Request::get('positions', []));
        if (\Request::ajax()) {
            return \Response::json(['status' => 'alert_success']);
        } else {
            return \Redirect::route('cc.products.index');
        }
    }


    public function toggleAttribute($categoryId, $productId, $attribute)
    {
        if (!in_array($attribute, ['publish'])) {
            \App::abort(404, "Not allowed to toggle this attribute");
        }
        $this->getCategory($categoryId);
        $product = $this->getProduct($categoryId, $productId);
        $this->productRepository->toggleAttribute($product, $attribute);

        return $this->toggleFlagResponse(
            route('cc.products.toggle-attribute', [$categoryId, $productId, $attribute]),
            $product,
            $attribute
        );
    }


    public function edit($categoryId, $productId)
    {
        $category = $this->getCategory($categoryId);
        $product = $this->getProduct($categoryId, $productId);
        $productList = $this->getProductList($category);
        $formData = $this->formDataProvider->provideDataFor($product, \Request::old());
        $breadcrumbs = $this->breadcrumbs->getFor('category.product.edit', $product);

        return \View::make('admin.products.edit')
            ->with('breadcrumbs', $breadcrumbs)
            ->with('category', $category)
            ->with('product', $product)
            ->with('productList', $productList)
            ->with('formData', $formData);
    }

    public function update($categoryId, $productId)
    {
        $category = $this->getCategory($categoryId);
        $product = $this->getProduct($categoryId, $productId);
        $success = $this->formProcessor->update($product, \Request::except('redirect_to'));
        if (!$success) {
            return \Redirect::route('cc.products.edit', [$category->id, $product->id])
                ->withErrors($this->formProcessor->errors())->withInput();
        } else {
            if (\Request::get('redirect_to') == 'index') {
                $redirect = \Redirect::route('cc.products.index', [$category->id]);
            } else {
                $redirect = \Redirect::route('cc.products.edit', [$product->category_id, $product->id]);
            }

            return $redirect->with('alert_success', "Товар обновлён");
        }
    }


    public function destroy($categoryId, $productId)
    {
        $category = $this->getCategory($categoryId);
        $product = $this->getProduct($categoryId, $productId);
        $this->productRepository->delete($product);

        return \Redirect::route('cc.products.index', $category->id)->with('alert_success', 'Товар удалён');
    }


    /**
     * Get category by id or throw error 404.
     *
     * @param $categoryId
     * @return \App\Models\Category
     */
    private function getCategory($categoryId)
    {
        $category = $this->categoryRepository->findById($categoryId);
        if (is_null($category)) {
            \App::abort(404, 'Category not found');
        }

        return $category;
    }


    /**
     * Get product by category and product ids or throw error 404.
     *
     * @param $categoryId
     * @param $productId
     * @return \App\Models\Product
     */
    private function getProduct($categoryId, $productId)
    {
        $product = $this->productRepository->findById($productId);
        if (is_null($product)) {
            \App::abort(404, 'Product not found');
        }
        if ($product->category->id != $categoryId) {
            \App::abort(404, 'Product not placed in specified category');
        }

        return $product;
    }

    public function store($categoryId)
    {
        $category = $this->getCategory($categoryId);
        $product = $this->formProcessor->create(\Request::except('redirect_to'));
        if (is_null($product)) {
            return \Redirect::route('cc.products.create', [$category->id])
                ->withErrors($this->formProcessor->errors())->withInput();
        } else {
            if (\Request::get('redirect_to') == 'index') {
                $redirect = \Redirect::route('cc.products.index', [$category->id]);
            } else {
                $redirect = \Redirect::route('cc.products.edit', [$product->category_id, $product->id]);
            }

            return $redirect->with('alert_success', "Товар создан");
        }
    }
}
