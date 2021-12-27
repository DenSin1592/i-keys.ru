<?php

namespace App\Services\Validation\Attribute;

use App\Models\Attribute;
use App\Services\Validation\AbstractLaravelValidator;

class ProductsSeriesLaravelValidator extends AbstractLaravelValidator
{
    protected function getRules()
    {
        return [
            'value' => 'required',
            'attribute_id' => ['required', 'in:' . implode(',', Attribute\AttributeConstants::SERIES_ATTRIBUTES), 'exists:attributes,id'],
        ];
    }
}
