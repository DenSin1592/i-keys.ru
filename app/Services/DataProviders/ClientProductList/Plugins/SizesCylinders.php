<?php

namespace App\Services\DataProviders\ClientProductList\Plugins;

use App\Models\Attribute\AttributeConstants;
use App\Models\Product;
use App\Services\DataProviders\ClientProductList\ClientProductListPlugin;
use Illuminate\Database\Eloquent\Collection;


class SizesCylinders implements ClientProductListPlugin
{
    public function getForProductsList($products, array $additionalData = []): array
    {
        $array = [];

        foreach ($products as $element){
            if($element->isCylinder()){
                $results = $this->getDataForCylinder($element);
            }
            if(!empty($results)){
                $array[$element->id] = $results;
            }
        }

        return ['sizes_cylinder' => $array];
    }


    private function getDataForCylinder($product)
    {
        $seriesCylinderValueId = $product->getIdSingleValues(AttributeConstants::CYLINDER_SERIES_ID);
        $cylinderOpeningTypeValueId = $product->getIdSingleValues(AttributeConstants::CYLINDER_OPENING_TYPE_ID);
        $colorValueId = $product->getIdSingleValues(AttributeConstants::COLOR_ID);

        $attrSingleValSeriesCylinder = 'attribute_single_values'.AttributeConstants::CYLINDER_SERIES_ID;
        $attrSingleValCylinderOpeningType = 'attribute_single_values'.AttributeConstants::CYLINDER_OPENING_TYPE_ID;
        $attrSingleValColor = 'attribute_single_values'.AttributeConstants::COLOR_ID;

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
            })->leftJoin("attribute_single_values as $attrSingleValColor", static function ($join) use ($attrSingleValColor,){
                $join->on(
                    'products.id',
                    '=',
                    "{$attrSingleValColor}.product_id")
                    ->where("{$attrSingleValColor}.attribute_id", '=', AttributeConstants::COLOR_ID);
            })->leftJoin("attribute_single_values", static function ($join){
                $join->on(
                    'products.id',
                    '=',
                    "attribute_single_values.product_id")
                    ->where("attribute_single_values.attribute_id", '=', AttributeConstants::SIZE_CYLINDER_ID);
            })->leftJoin('attribute_allowed_values', 'attribute_allowed_values.id', '=', 'attribute_single_values.value_id')
            ->where('products.publish','=', true)
            ->where("{$attrSingleValSeriesCylinder}.value_id", '=', $seriesCylinderValueId)
            ->where("{$attrSingleValCylinderOpeningType}.value_id", '=', $cylinderOpeningTypeValueId)
            ->where("{$attrSingleValColor}.value_id", '=', $colorValueId)
            ->orderBy('attribute_allowed_values.value_first_size_cylinder')
            ->orderBy('attribute_allowed_values.value_second_size_cylinder')
            ->select('products.*', 'attribute_allowed_values.id as attr_id', 'attribute_allowed_values.value_first_size_cylinder as attr_size1',  'attribute_allowed_values.value_second_size_cylinder as attr_size2')
            ->get();

        if($products->count() === 0 ){
            $products = $this->getProductWithAttrValue($product);
        }

        if($products->count() === 0 ){
            return [];
        }

        $colors = [];
        foreach ($products as $element){
            $colors[] = [
                'product_id' => $element->id,
                'attr_value' => $element->attr_size1 . '*' . $element->attr_size2 . 'мм',
                'isActive' => $product->id === $element->id,
            ];
        }

      return $colors;
    }


    private function getProductWithAttrValue(Product $product): Collection
    {

        $productWithAttr = Product::query()->leftJoin("attribute_single_values", static function ($join){
            $join->on(
                'products.id',
                '=',
                "attribute_single_values.product_id")
                ->where("attribute_single_values.attribute_id", '=', AttributeConstants::SIZE_CYLINDER_ID);
        })->leftJoin('attribute_allowed_values', 'attribute_allowed_values.id', '=', 'attribute_single_values.value_id')
            ->where('products.id','=', $product->id)
            ->select(['products.*', 'attribute_allowed_values.id as attr_id', 'attribute_allowed_values.value_first_size_cylinder as attr_size1',  'attribute_allowed_values.value_second_size_cylinder as attr_size2'])
            ->first();

        return ( !empty($productWithAttr->attr_id))
            ? Collection::make([$productWithAttr])
            : Collection::make([]);
    }
}
