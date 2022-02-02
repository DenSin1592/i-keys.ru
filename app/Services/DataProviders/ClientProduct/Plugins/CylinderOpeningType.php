<?php

namespace App\Services\DataProviders\ClientProduct\Plugins;

use App\Models\Attribute\AttributeConstants;
use App\Models\Product;
use App\Services\DataProviders\ClientProduct\ClientProductPlugin;
use App\Services\Product\Attribute\CylinderOpeningType\CylinderOpeningTypeProvider;


class CylinderOpeningType implements ClientProductPlugin
{
    public function __construct(
        private CylinderOpeningTypeProvider $cylinderOpeningTypeProvider
    ){}


    public function getForProduct(Product $product): array
    {
        if (!$product->isCylinder()) {
           return [];
        }

        $array = $this->getData($product);

        if(empty($array)){
            return [];
        }

        return ['image_opening_cylinder_type' => $array];
    }



    private function getData(Product $product): array
    {
        $attrValue = $this->cylinderOpeningTypeProvider->getValueForProduct($product);

        switch ($attrValue->id){
            case AttributeConstants::CYLINDER_MECHANISM_TYPE_KEY_KEY:
                $result['src'] = asset('images/client/scheme/product-scheme-type-1.png');
                break;
            case AttributeConstants::CYLINDER_MECHANISM_TYPE_KEY_VERTUSHKA:
                $result['src'] = asset('images/client/scheme/product-scheme-type-2.png');
                break;
            case AttributeConstants::CYLINDER_MECHANISM_TYPE_KEY_SHTOCK:
                $result['src'] = asset('images/client/scheme/product-scheme-type-3.png');
                break;
            default:
                $result['src'] = asset('images/client/scheme/product-scheme-type-1.png');

        }

        $result['alt'] = $attrValue->value;
        return $result;
    }
}
