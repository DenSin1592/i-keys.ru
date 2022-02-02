<?php

namespace App\Services\Product\Attribute\CylinderOpeningType;

use App\Models\Attribute\AllowedValue;
use App\Models\Attribute\AttributeConstants;
use App\Models\Product;

class CylinderOpeningTypeProvider
{
    public function getValueForProduct(Product $model): AllowedValue
    {
        return $model->attributeSingleValues()
            ->where('attribute_id', AttributeConstants::CYLINDER_OPENING_TYPE_ID)
            ->first()?->allowedValue ?? new AllowedValue();
    }
}
