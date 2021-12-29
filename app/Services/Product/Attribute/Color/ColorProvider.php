<?php

namespace App\Services\Product\Attribute\Color;

use App\Models\Attribute\AttributeConstants;
use App\Models\Product;


class ColorProvider
{
    public function getColorFromCartItem(Product $model): array
    {
        $color = [];

        $attrValue = $model->attributeSingleValues()->where('attribute_id', AttributeConstants::COLOR_ID)->first()?->allowedValue;

        if(!is_null($attrValue)){
            $color = [
                'name' => $attrValue->value,
                'imgPath' => match ($attrValue->id){
                    AttributeConstants::COLOR_LATUN_ID => asset('/uploads/colors/color-brown.png'),
                    AttributeConstants::COLOR_NICKEL_ID => asset('/uploads/colors/color-silver.png'),
                    default => asset('/images/common/no-image/no-image-40x40.png'),
                }
            ];
        }

        return $color;
    }

}
