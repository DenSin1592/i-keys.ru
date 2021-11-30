<?php

namespace App\Http\Controllers\Client\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Product;


class ProductsController extends Controller
{
    use CatalogBreadcrumbs;

    public function __construct(
//        private  EloquentProductRepository $productRepository,
//        private  ClientProduct $productProvider,
//        private  MetaHelper $metaHelper,
//        private  Breadcrumbs $breadcrumbs
    ){}

    public function getResponse(Product $product,)
    {

        dd(__METHOD__);
//        $product = $this->productRepository->findPublishedById($id);
//        if (is_null($product)) {
//            \App::abort(404, 'Product page is not found');
//        }
//        /** @var Category $category */
//        $category = $product->category;
//        $metaData = $this->metaHelper->getRule('product')->metaForObject($product);
//        $breadcrumbs = $this->getBreadcrumbs($this->breadcrumbs, $category->extractPath());
//        $breadcrumbs->add($product->name, \UrlBuilder::getUrl($product));
//        $productData = $this->productProvider->getProductData($product);
//
//        return \View::make('client.products.show')
//            ->with('product', $product)
//            ->with('productData', $productData)
//            ->with('breadcrumbs', $breadcrumbs)
//            ->with('authEditLink', route('cc.products.edit', [$category->id, $product->id]))
//            ->with('currentCategory', $category)
//            ->with($metaData);
    }
}
