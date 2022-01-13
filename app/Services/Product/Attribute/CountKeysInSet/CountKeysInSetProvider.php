<?php

namespace App\Services\Product\Attribute\CountKeysInSet;

use App\Models\Attribute\AttributeConstants;
use App\Models\Product;


class CountKeysInSetProvider
{
    public function getCountKeysFromCartItem(Product $model): int
    {
        $value = 0;

        $attrValue = $model->attributeSingleValues()->where('attribute_id', AttributeConstants::COUNT_KEYS_IN_SET_ID)->first()?->allowedValue;

        if(!is_null($attrValue)){
            $value = (int)$attrValue->value;
        }

        return $value;
    }

}
