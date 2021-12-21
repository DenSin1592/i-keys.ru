<?php

namespace App\Services\DataProviders\ClientProduct\Plugins;

use App\Models\Product;
use App\Services\DataProviders\ClientProduct\ClientProductPlugin;
use App\Services\DataProviders\ClientProductList\ClientProductList;
use App\Services\Repositories\Product\EloquentProductRepository;

class RelatedProducts implements ClientProductPlugin
{

    public function __construct(
        private EloquentProductRepository $productRepository,
        private ClientProductList $productListProvider,
    ){}


    public function getForProduct(Product $product): array
    {
        $relatedProducts = $this->productRepository->relatedProductsForProduct($product, true);
        $relatedProductsData = $this->productListProvider->getProductListData($relatedProducts);

        if($product->isCylinder()){
            $relatedProductsFinal = $this->getForCylinder($relatedProductsData);
        }else{
            $relatedProductsFinal = $this->getDefaultRelatedProduct($relatedProductsData);
        }

        return ['relatedProductsData' => $relatedProductsFinal];
    }


    private function getForCylinder(array $relatedProductsData): array
    {
        $array = [];

        foreach ($relatedProductsData as $key => $element){
            if($element['product']->isLock()){
                $array['locks'][] = $element;
                unset($relatedProductsData[$key]);
                continue;
            }
            if($element['product']->isArmorplate()){
                $array['armorplate'][] = $element;
                unset($relatedProductsData[$key]);
                continue;
            }

        }

        $array = array_merge($array, $this->getDefaultRelatedProduct($relatedProductsData));

        return $array;
    }


    private function getDefaultRelatedProduct(array $relatedProductsData): array
    {
        $array = [];

        foreach ($relatedProductsData as $element){
            if($element['product']->isLock()){
                $array['locks'][] = $element;
                continue;
            }
            if($element['product']->isCylinder()){
                $array['cylinders'][] = $element;
                continue;
            }
            if($element['product']->isDoorHandle()){
                $array['door_handle'][] = $element;
                continue;
            }
            if($element['product']->isFindings()){
                $array['findings'][] = $element;
                continue;
            }

            $array['other'][] = $element;
            continue;
        }

        return !empty($array) ? ['default' => $array] : [];
    }

}
