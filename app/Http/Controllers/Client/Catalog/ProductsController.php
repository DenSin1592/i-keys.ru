<?php

namespace App\Http\Controllers\Client\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\DataProviders\ClientProduct\ClientProduct;
use App\Services\Seo\MetaHelper;
use App\Services\Breadcrumbs\Factory as Breadcrumbs;


class ProductsController extends Controller
{
    use CatalogBreadcrumbs;

    public function __construct(
        private  ClientProduct $productProvider,
        private  MetaHelper $metaHelper,
        private  Breadcrumbs $breadcrumbs
    ){}

    public function getResponse(Product $product)
    {
        $productData = $this->productProvider->getProductData($product);
        $metaData = $this->metaHelper->getRule()->metaForObject($product);
        $breadcrumbs = $this->getBreadcrumbs($product);

        return \View::make('client.product.show',[
                'breadcrumbs' => $breadcrumbs,
                'authEditLink' =>  route('cc.products.edit', [$product->category->id, $product->id]),
                'metaData' => $metaData,
                'productData' => $productData,
            ]
        );
    }


    private function getBreadcrumbs(Product $product)
    {

        $breadcrumbs = $this->getBreadcrumbsForCategories($this->breadcrumbs, $product->category->extractPath());
        $breadcrumbs->add($product->name, \UrlBuilder::getUrl($product));

        return $breadcrumbs;
    }
}
