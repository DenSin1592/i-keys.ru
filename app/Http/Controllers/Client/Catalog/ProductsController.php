<?php

namespace App\Http\Controllers\Client\Catalog;

use App\Facades\UrlBuilder;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\DataProviders\ClientProduct\ClientProduct;
use App\Services\Product\GetProductByCylinderSizes;
use App\Services\Product\ProductUrlBuilder;
use App\Services\Seo\MetaHelper;
use App\Services\Breadcrumbs\Factory as Breadcrumbs;
use Illuminate\Http\JsonResponse;


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


    public function getContentWhenChangingSizeCylinder(): JsonResponse
    {
        $productId = (int)\Request::get('productId');
        $firstSize = (int)\Request::get('firstSize');
        $secondSize = (int)\Request::get('secondSize');
        $selectedSelectNumber = (int)\Request::get('selectedSelectNumber');

        $searchedProduct = (new GetProductByCylinderSizes($productId, $firstSize, $secondSize, $selectedSelectNumber,))->getProductWhenChangingSizes();

        return $this->getJsonForProductWhenChangingColorOrSize($searchedProduct);
    }


    public function getContentWhenChangingColor(): JsonResponse
    {
        $productId = (int)\Request::get('productId');

        $product = Product::find($productId);

        return $this->getJsonForProductWhenChangingColorOrSize($product);

    }


    private function getJsonForProductWhenChangingColorOrSize($product): JsonResponse
    {
        $productData = $this->productProvider->getProductData($product);
        $breadcrumbs = $this->getBreadcrumbs($product);
        $metaData = $this->metaHelper->getRule()->metaForObject($product);

        $contentHTML = \View::make('client.product._inner_show', [
            'productData' => $productData,
            'breadcrumbs' => $breadcrumbs,
            'metaData' => $metaData,
        ])->render();

        $modalAddKeysHTML = \View::make('client.shared.modal._add_keys', [
            'productData' => $productData,
        ])->render();

        $newUrl = UrlBuilder::getUrl($product);

        return \Response::json([
            'content' => $contentHTML,
            'modal_add_keys' => $modalAddKeysHTML,
            'new_url' => $newUrl,
        ]);
    }


    private function getBreadcrumbs(Product $product)
    {
        $breadcrumbs = $this->getBreadcrumbsForCategories($this->breadcrumbs, $product->category->extractPath());
        $breadcrumbs->add($product->name, \UrlBuilder::getUrl($product));

        return $breadcrumbs;
    }
}




