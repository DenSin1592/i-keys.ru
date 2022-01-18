<?php

namespace App\Services\DataProviders\ClientProduct\Plugins;

use App\Models\Attribute\AttributeConstants;
use App\Services\DataProviders\ClientProduct\ClientProductPlugin;
use App\Services\Product\Attribute\Color\DataProvider;


class Colors implements ClientProductPlugin
{

    public function __construct(
        private DataProvider $dataProvider
    ){}

    public function getForProduct($product): array
    {
        if($product->isCylinder()){
            $array = $this->getDataForCylinder($product);
        }

        if(empty($array)){
            return [];
        }

        return ['colors' => $array];
    }


    private function getDataForCylinder($product)
    {
        $products = $this->dataProvider->getBuilderByProductSeries($product)
            ->orderBy('attribute_allowed_values.value')
            ->select('products.*', 'attribute_allowed_values.id as attr_id', 'attribute_allowed_values.value as attr_value' )
            ->get();

        if($products->count() === 0 ){
            $products = $this->dataProvider->getCollectionOneProductWithAttrValue($product);
        }

        if($products->count() === 0 ){
            return [];
        }


        $colors = [];
        foreach ($products as $element){
            $isActive = $product->id === $element->id;

            $colors[] = [
                'link' => \UrlBuilder::getUrl($element),
                'attr_value' => $element->attr_value,
                'isActive' => $isActive,
                'imgPath' => match ($element->attr_id){
                    AttributeConstants::COLOR_LATUN_ID => asset('/uploads/colors/color-brown.png'),
                    AttributeConstants::COLOR_NICKEL_ID => asset('/uploads/colors/color-silver.png'),
                    default => asset('/images/common/no-image/no-image-40x40.png'),
                }
            ];
        }


      return $colors;
    }
}
