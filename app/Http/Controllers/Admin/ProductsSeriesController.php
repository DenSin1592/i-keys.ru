<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DataProviders\ProductsSeriesForm\ProductsSeriesForm;
use App\Services\Repositories\ProductSeries\EloquentProductsSeriesRepository;


class ProductsSeriesController extends Controller
{

    public function __construct(
        private EloquentProductsSeriesRepository $repository,
        private ProductsSeriesForm $dataProvider,
    ){}


    public function index()
    {
        $modelList = $this->repository->paginate();
        return view('admin.products_series.index', [
            'modelList' => $modelList
        ]);
    }


    public function create()
    {
        $model = $this->repository->newInstance();

        return view('admin.products_series.create', [
            'formData' => $this->dataProvider->provideDataFor($model),
        ]);
    }


    public function store()
    {
        $model = $this->formProcessor->create(\Request::except('redirect_to'));

//        if (is_null($product)) {
//            return \Redirect::route('cc.products.create', [$category->id])
//                ->withErrors($this->formProcessor->errors())->withInput();
//        }
//        if (\Request::get('redirect_to') == 'index') {
//            $redirect = \Redirect::route('cc.products.index', [$category->id]);
//        } else {
//            $redirect = \Redirect::route('cc.products.edit', [$product->category_id, $product->id]);
//        }
//
//        return $redirect->with('alert_success', "Товар создан");

    }


//    public function edit($categoryId, $productId)
//    {
//        $category = $this->getCategory($categoryId);
//        $product = $this->getProduct($categoryId, $productId);
//        $productList = $this->getProductList($category);
//        $formData = $this->formDataProvider->provideDataFor($product, \Request::old());
//        $breadcrumbs = $this->breadcrumbs->getFor('category.product.edit', $product);
//
//        return \View::make('admin.products.edit')
//            ->with('breadcrumbs', $breadcrumbs)
//            ->with('category', $category)
//            ->with('product', $product)
//            ->with('productList', $productList)
//            ->with('formData', $formData);
//    }

//    public function update($categoryId, $productId)
//    {
//        $category = $this->getCategory($categoryId);
//        $product = $this->getProduct($categoryId, $productId);
//        $success = $this->formProcessor->update($product, \Request::except('redirect_to'));
//        if (!$success) {
//            return \Redirect::route('cc.products.edit', [$category->id, $product->id])
//                ->withErrors($this->formProcessor->errors())->withInput();
//        } else {
//            if (\Request::get('redirect_to') == 'index') {
//                $redirect = \Redirect::route('cc.products.index', [$category->id]);
//            } else {
//                $redirect = \Redirect::route('cc.products.edit', [$product->category_id, $product->id]);
//            }
//
//            return $redirect->with('alert_success', "Товар обновлён");
//        }
//    }


//    public function destroy($categoryId, $productId)
//    {
//        $category = $this->getCategory($categoryId);
//        $product = $this->getProduct($categoryId, $productId);
//        $this->productRepository->delete($product);
//
//        return \Redirect::route('cc.products.index', $category->id)->with('alert_success', 'Товар удалён');
//    }


//    private function getProductList(Category $category)
//    {
//        return $this->flexPaginator->make(
//            function ($page, $limit) use ($category) {
//                return $this->productRepository->allInCategoryByPage($category->id, $page, $limit);
//            },
//            "product-pagination-page-{$category->id}",
//            'product-pagination-limit'
//        );
//    }


}
