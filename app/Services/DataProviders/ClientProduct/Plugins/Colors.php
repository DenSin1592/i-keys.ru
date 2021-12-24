<?php

namespace App\Services\DataProviders\ClientProduct\Plugins;

use App\Models\Attribute\AttributeConstants;
use App\Models\Product;
use App\Services\DataProviders\ClientProduct\ClientProductPlugin;
use App\Services\UrlBuilder\UrlBuilder;


class Colors implements ClientProductPlugin
{

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
        $seriesCylinderValueId = $product->getIdSingleValues(AttributeConstants::CYLINDER_SERIES_ID);
        $cylinderOpeningTypeValueId = $product->getIdSingleValues(AttributeConstants::CYLINDER_OPENING_TYPE_ID);
        $sizeCylinderValueId = $product->getIdSingleValues(AttributeConstants::SIZE_CYLINDER_ID);

        $attrSingleValSeriesCylinder = 'attribute_single_values'.AttributeConstants::CYLINDER_SERIES_ID;
        $attrSingleValCylinderOpeningType = 'attribute_single_values'.AttributeConstants::CYLINDER_OPENING_TYPE_ID;
        $attrSingleValSizeCylinder = 'attribute_single_values'.AttributeConstants::SIZE_CYLINDER_ID;

        $products = Product::query()
            ->leftJoin("attribute_single_values as $attrSingleValSeriesCylinder", static function ($join) use ($attrSingleValSeriesCylinder,){
                $join->on(
                    'products.id',
                    '=',
                    "{$attrSingleValSeriesCylinder}.product_id")
                    ->where("{$attrSingleValSeriesCylinder}.attribute_id", '=', AttributeConstants::CYLINDER_SERIES_ID);
            })->leftJoin("attribute_single_values as $attrSingleValCylinderOpeningType", static function ($join) use ($attrSingleValCylinderOpeningType,){
                $join->on(
                    'products.id',
                    '=',
                    "{$attrSingleValCylinderOpeningType}.product_id")
                    ->where("{$attrSingleValCylinderOpeningType}.attribute_id", '=', AttributeConstants::CYLINDER_OPENING_TYPE_ID);
            })->leftJoin("attribute_single_values as $attrSingleValSizeCylinder", static function ($join) use ($attrSingleValSizeCylinder,){
                $join->on(
                    'products.id',
                    '=',
                    "{$attrSingleValSizeCylinder}.product_id")
                    ->where("{$attrSingleValSizeCylinder}.attribute_id", '=', AttributeConstants::SIZE_CYLINDER_ID);
            })->leftJoin("attribute_single_values", static function ($join){
                $join->on(
                    'products.id',
                    '=',
                    "attribute_single_values.product_id")
                    ->where("attribute_single_values.attribute_id", '=', AttributeConstants::COLOR_ID);
            })->leftJoin('attribute_allowed_values', 'attribute_allowed_values.id', '=', 'attribute_single_values.value_id')
            ->where('products.publish','=', true)
            ->where("{$attrSingleValSeriesCylinder}.value_id", '=', $seriesCylinderValueId)
            ->where("{$attrSingleValCylinderOpeningType}.value_id", '=', $cylinderOpeningTypeValueId)
            ->where("{$attrSingleValSizeCylinder}.value_id", '=', $sizeCylinderValueId)
            ->orderBy('attribute_allowed_values.value')
            ->select('products.*', 'attribute_allowed_values.id as attr_id', 'attribute_allowed_values.value as attr_value' )
            ->get();


        if($products->count() === 0 ){
            return [];
        }


        $colors = [];
        foreach ($products as $element){
            $colors[] = [
                'link' => \UrlBuilder::getUrl($element),
                'attr_value' => $element->attr_value,
                'isActive' => $product->id === $element->id,
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
