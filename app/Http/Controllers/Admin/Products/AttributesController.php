<?php namespace App\Http\Controllers\Admin\Products;

use App\Http\Controllers\Controller;
use App\Services\DataProviders\ProductForm\ProductSubForm\Attributes;
use App\Services\Repositories\Category\EloquentCategoryRepository;
use App\Services\Repositories\Product\EloquentProductRepository;

class AttributesController extends Controller
{
    private $categoryRepository;
    private $productRepository;
    private $dataProvider;

    public function __construct(
        EloquentCategoryRepository $categoryRepository,
        EloquentProductRepository $productRepository,
        Attributes $dataProvider
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->dataProvider = $dataProvider;
    }

    public function show($categoryId, $productId = null)
    {
        $category = $this->categoryRepository->findById($categoryId);
        if (is_null($category)) {
            \App::abort(404, 'Category not found');
        }

        if (is_null($productId)) {
            $product = $this->productRepository->newInstanceWithCategory($category);
        } else {
            $product = $this->productRepository->findById($productId);
        }
        if (is_null($product)) {
            \App::abort(404, 'Product not found');
        }

        $formData = $this->dataProvider->provideDataFor($product, \Request::all());
        $content = \View::make('admin.products.form.attributes._attributes', ['formData' => $formData])->render();

        return \Response::json(['content' => $content]);
    }
}
