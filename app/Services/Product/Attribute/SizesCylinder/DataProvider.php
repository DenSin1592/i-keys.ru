<?php

namespace App\Services\Product\Attribute\SizesCylinder;

use App\Models\Attribute\AttributeConstants;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


class DataProvider
{
    public static function getBuilderByProductSeries (Product $product): Builder
    {
        $seriesCylinderValueId = $product->getIdSingleValues(AttributeConstants::CYLINDER_SERIES_ID);
        $cylinderOpeningTypeValueId = $product->getIdSingleValues(AttributeConstants::CYLINDER_OPENING_TYPE_ID);
        $colorValueId = $product->getIdSingleValues(AttributeConstants::COLOR_ID);

        $attrSingleValSeriesCylinder = 'attribute_single_values'.AttributeConstants::CYLINDER_SERIES_ID;
        $attrSingleValCylinderOpeningType = 'attribute_single_values'.AttributeConstants::CYLINDER_OPENING_TYPE_ID;
        $attrSingleValColor = 'attribute_single_values'.AttributeConstants::COLOR_ID;

        $builder = Product::query()
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
            ->where("{$attrSingleValColor}.value_id", '=', $colorValueId);

        return $builder;
    }


    public static function getCollectionOneProductWithAttrValue(Product $product): Collection
    {
        $productWithAttr = Product::query()->leftJoin("attribute_single_values", static function ($join){
            $join->on(
                'products.id',
                '=',
                "attribute_single_values.product_id")
                ->where("attribute_single_values.attribute_id", '=', AttributeConstants::SIZE_CYLINDER_ID);
        })->leftJoin('attribute_allowed_values', 'attribute_allowed_values.id', '=', 'attribute_single_values.value_id')
            ->where('products.id','=', $product->id)
            ->select(['products.*', 'attribute_allowed_values.id as attr_id', 'attribute_allowed_values.value_first_size_cylinder as value_first_size_cylinder',  'attribute_allowed_values.value_second_size_cylinder as value_second_size_cylinder'])
            ->first();

        return (!empty($productWithAttr->attr_id))
            ? Collection::make([$productWithAttr])
            : Collection::make([]);
    }
}
