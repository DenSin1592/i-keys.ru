<?php namespace App\Services\DataProviders\AttributeForm\AttributeSubForm;

use App\Models\Attribute;

class DecimalScale extends AttributeType
{
    protected function provideTypeDataFor($attributeType, Attribute $attribute, array $oldInput)
    {
        $data = [];
        if ($attributeType === Attribute::TYPE_DECIMAL) {
            $decimalScale = \Arr::get($oldInput, 'decimal_scale', $attribute->decimal_scale);
            $data['isDecimal'] = true;
            $data['decimalScale'] = $decimalScale;
        }

        return $data;
    }
}
