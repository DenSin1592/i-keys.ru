<?php

namespace App\Models\Product;

use App\Models\Features\ConstantsGetter;


class ExistenceConstants
{
    use ConstantsGetter;

    const AVAILABLE = 1;
    const FOR_ORDER = 2;
    const STOP_PRODUCTION = 3;


    public static function getExistenceVariants()
    {
        $variants = [];
        foreach (self::getConstants() as $c) {
            $variants[$c] = trans("validation.model_attributes.product.existence.{$c}");
        }

        return $variants;
    }


}
