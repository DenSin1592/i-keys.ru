<?php

namespace App\Services\DataProviders\ProductsSeriesForm\Plugins;

use App\Models\Attribute\AttributeConstants;
use App\Services\DataProviders\ProductsSeriesForm\ProductsSeriesFormPlugin;


class Products implements ProductsSeriesFormPlugin
{
    public function getSubData($item, array $additionalData = []): array
    {
        $products = $item->productsForSingle;


        if ($item->attribute_id === AttributeConstants::LOCK_SERIES_ID){
            foreach ($products as $key => $element){
                if(!$element->isLock()){
                    $products->forget($key);
                }
            }
        }

        if ($item->attribute_id === AttributeConstants::CYLINDER_SERIES_ID){
            foreach ($products as $key => $element){
                if(!$element->isCylinder()){
                    $products->forget($key);
                }
            }
        }

        return ['products' => $products];
    }
}
