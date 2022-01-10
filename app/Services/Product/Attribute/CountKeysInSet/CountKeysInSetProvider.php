<?php

namespace App\Services\Product\Attribute\CountKeysInSet;

use App\Models\Attribute\AttributeConstants;
use App\Models\Product;


class CountKeysInSetProvider
{
    public function getCountKeysFromCartItem(Product $model): array
    {
        $value = [];

        $attrValue = $model->attributeSingleValues()->where('attribute_id', AttributeConstants::COUNT_KEYS_IN_SET_ID)->first()?->allowedValue;

        if(!is_null($attrValue)){
            $value = [
                'value' => (int)$attrValue->value,
            ];
        }

        return $value;
    }

}
