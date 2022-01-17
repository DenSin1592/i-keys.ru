<?php

namespace App\Services\Product;

use App\Models\Attribute\AttributeConstants;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;


class ProductUrlBuilder
{
    private Builder $productBuilder;

    public function __construct(
        private int $productId,
        private int $firstSize,
        private int $secondSize,
        private int $selectedSelectNumber,
    ){}


    public function getProductWhenChangingSizes(): Product
    {
        $product = Product::find($this->productId);

        $newProduct = $this->geProductByTwoSizes($product);

        if(is_null($newProduct)){
            $newProduct = $this->getFirstProductByOneSize();
        }

        return $newProduct;
    }


    private function geProductByTwoSizes(Product $product): ?Product
    {
        $seriesCylinderValueId = $product->getIdSingleValues(AttributeConstants::CYLINDER_SERIES_ID);
        $cylinderOpeningTypeValueId = $product->getIdSingleValues(AttributeConstants::CYLINDER_OPENING_TYPE_ID);
        $colorValueId = $product->getIdSingleValues(AttributeConstants::COLOR_ID);

        $attrSingleValSeriesCylinder = 'attribute_single_values'.AttributeConstants::CYLINDER_SERIES_ID;
        $attrSingleValCylinderOpeningType = 'attribute_single_values'.AttributeConstants::CYLINDER_OPENING_TYPE_ID;
        $attrSingleValColor = 'attribute_single_values'.AttributeConstants::COLOR_ID;

        $this->productBuilder = Product::query()
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

        $productBuilder = clone $this->productBuilder;

        $product = $productBuilder->where('attribute_allowed_values.value_first_size_cylinder', '=', $this->firstSize)
            ->where('attribute_allowed_values.value_second_size_cylinder', '=', $this->secondSize)
            ->first();

        return $product;
    }


    private function getFirstProductByOneSize(): Product
    {
        if($this->selectedSelectNumber === 1){
            $product = $this->productBuilder
                ->where('attribute_allowed_values.value_first_size_cylinder', '=', $this->firstSize)
                ->first();
        }else{
            $product = $this->productBuilder
                ->where('attribute_allowed_values.value_second_size_cylinder', '=', $this->secondSize)
                ->first();
        }

        return $product;
    }
}
