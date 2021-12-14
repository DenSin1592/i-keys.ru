<?php

namespace App\Http\Controllers\Client\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Seo\MetaHelper;
use App\Services\Breadcrumbs\Factory as Breadcrumbs;


class ProductsController extends Controller
{
    use CatalogBreadcrumbs;

    public function __construct(
//        private  EloquentProductRepository $productRepository,
//        private  ClientProduct $productProvider,
        private  MetaHelper $metaHelper,
        private  Breadcrumbs $breadcrumbs
    ){}

    public function getResponse(Product $product)
    {
        $metaData = $this->metaHelper->getRule()->metaForObject($product);
        $breadcrumbs = $this->getBreadcrumbs($product);

        return \View::make('client.product.show',[
                'breadcrumbs' => $breadcrumbs,
                'authEditLink' =>  route('cc.products.edit', [$product->category->id, $product->id]),
                'metaData' => $metaData,
                'product' => $product,
            ]
        );
//            ->with('breadcrumbs', $breadcrumbs)
//           ->with('authEditLink', route('cc.products.edit', [->id, $product->id]))
//            ->with('metadata', $metaData);



//        $product = $this->productRepository->findPublishedById($id);
//        if (is_null($product)) {
//            \App::abort(404, 'Product page is not found');
//        }
//        /** @var Category $category */
//
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


    private function getBreadcrumbs(Product $product)
    {

        $breadcrumbs = $this->getBreadcrumbsForCategories($this->breadcrumbs, $product->category->extractPath());
        $breadcrumbs->add($product->name, \UrlBuilder::getUrl($product));

        return $breadcrumbs;
    }
}
