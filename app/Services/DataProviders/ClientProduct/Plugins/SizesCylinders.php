<?php

namespace App\Services\DataProviders\ClientProduct\Plugins;

use App\Models\Attribute\AttributeConstants;
use App\Models\Product;
use App\Services\DataProviders\ClientProduct\ClientProductPlugin;
use App\Services\Product\Attribute\SizesCylinder\DataProvider;
use Illuminate\Database\Eloquent\Collection;


class SizesCylinders implements ClientProductPlugin
{
    private Product $product;
    private string $value_first_size_cylinder;
    private string $value_second_size_cylinder;

    public function getForProduct($product): array
    {
        $this->product = $product;
        

        $array = [];

        if($product->isCylinder()){
            $this->initProperties();
            $array = $this->getDataForCylinder($product);
        }

        return ['sizesCylinder' => $array];
    }


    private function initProperties(): void
    {
        $attrAllowedValue = $this->product->getSingleAllowedValue(AttributeConstants::SIZE_CYLINDER_ID);
        $this->value_first_size_cylinder = $attrAllowedValue->value_first_size_cylinder;
        $this->value_second_size_cylinder = $attrAllowedValue->value_second_size_cylinder;
    }


    private function getDataForCylinder($product)
    {
        $products = DataProvider::getBuilderByProductSeries($product)
            ->orderBy('attribute_allowed_values.value_first_size_cylinder')
            ->orderBy('attribute_allowed_values.value_second_size_cylinder')
            ->select('products.id', 'attribute_allowed_values.id as attr_id', 'attribute_allowed_values.value_first_size_cylinder as value_first_size_cylinder',  'attribute_allowed_values.value_second_size_cylinder as value_second_size_cylinder')
            ->get();

        if($products->count() === 0 ){
            $products = DataProvider::getCollectionOneProductWithAttrValue($product);
        }

        if($products->count() === 0 ){
            return [];
        }

        $attrValues = [];

        $attrValues['first_sizes'] = $this->getDataForFieldSize($products, 'value_first_size_cylinder');
        $attrValues['second_sizes'] = $this->getDataForFieldSize($products, 'value_second_size_cylinder');

        return $attrValues;
    }


    private function getDataForFieldSize($products, string $fieldSize)
    {
        $attrValues = [];
        $uniqueValues = [];

        foreach ($products as $element){
            $size = $element->$fieldSize;
            if(in_array($size, $uniqueValues, true)){
                continue;
            }

            $isActive = $this->$fieldSize === $size;

            if($isActive && (is_null($size))){
                $attrValues = [];
                break;
            }

            if(is_null($size)){
                continue;
            }
            $attrValues[] = [
                'value' => $size,
                'isActive' => $isActive,
            ];
            $uniqueValues[] = $size;
        }

        sort($attrValues);

        return $attrValues;
    }
}
