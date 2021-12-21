<?php

namespace App\Services\DataProviders\ClientProduct\Plugins;

use App\Models\Product;
use App\Services\DataProviders\ClientProduct\ClientProductPlugin;
use App\Services\Repositories\Product\EloquentProductRepository;
use Illuminate\Database\Eloquent\Collection;

class RelatedProducts implements ClientProductPlugin
{

    public function __construct(
        private EloquentProductRepository $productRepository
    ){}


    public function getForProduct(Product $product): array
    {
        $relatedProducts = $this->productRepository->relatedProductsForProduct($product, true);

        if($product->isCylinder()){
            $relatedProductsFinal = $this->getForCylinder($relatedProducts);
        }else{
            $relatedProductsFinal['default'] = $this->getDefaultRelatedProduct($relatedProducts);
        }

        return ['relatedProductsData' => $relatedProductsFinal];
    }


    private function getForCylinder(Collection $relatedProducts): array
    {
        $array = [];

        foreach ($relatedProducts as $key => $element){
            if($element->isLock()){
                $array['locks'][] = $element;
                unset($relatedProducts[$key]);
                continue;
            }
            if($element->isArmorplate()){
                $array['armorplate'][] = $element;
                unset($relatedProducts[$key]);
                continue;
            }

        }

        $array['default'] = $this->getDefaultRelatedProduct($relatedProducts);
        return $array;
    }


    private function getDefaultRelatedProduct(Collection $relatedProducts): array
    {
        $array = [];

        foreach ($relatedProducts as $element){
            if($element->isLock()){
                $array['Замки'][] = $element;
                continue;
            }
            if($element->isCylinder()){
                $array['Цилиндры'][] = $element;
                continue;
            }
            if($element->isDoorHandle()){
                $array['Ручки'][] = $element;
                continue;
            }
            if($element->isFindings()){
                $array['Фурнитура'][] = $element;
                continue;
            }

            $array['Другое'][] = $element;
            continue;
        }

        return $array;
    }

}
