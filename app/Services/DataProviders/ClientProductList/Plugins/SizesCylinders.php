<?php

namespace App\Services\DataProviders\ClientProductList\Plugins;

use App\Models\Attribute\AttributeConstants;
use App\Models\Product;
use App\Services\DataProviders\ClientProductList\ClientProductListPlugin;
use App\Services\Product\Attribute\SizesCylinder\DataProvider;
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
        $products = DataProvider::getBuilderByProductSeries($product)
            ->orderBy('attribute_allowed_values.value_first_size_cylinder')
            ->orderBy('attribute_allowed_values.value_second_size_cylinder')
            ->select('products.*', 'attribute_allowed_values.value_first_size_cylinder as value_first_size_cylinder',  'attribute_allowed_values.value_second_size_cylinder as value_second_size_cylinder')
            ->get();

        if($products->count() === 0 ){
            $products = DataProvider::getCollectionOneProductWithAttrValue($product);
        }

        if($products->count() === 0 ){
            return [];
        }

        $attrValues = [];
        foreach ($products as $element){
            $isActive = $product->id === $element->id;

            if($isActive && (is_null($element->value_first_size_cylinder) || is_null($element->value_second_size_cylinder))){
                $attrValues = [];
                break;
            }

            $attrValues[] = [
                'product_id' => $element->id,
                'attr_value' => $element->value_second_size_cylinder . '*' . $element->value_second_size_cylinder . 'мм',
                'isActive' => $isActive,
            ];
        }

      return $attrValues;
    }
}
