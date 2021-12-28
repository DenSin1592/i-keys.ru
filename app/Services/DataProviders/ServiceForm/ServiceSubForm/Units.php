<?php namespace App\Services\DataProviders\AttributeForm\AttributeSubForm;

use App\Models\Attribute;

class Units extends AttributeType
{
    protected function provideTypeDataFor($attributeType, Attribute $attribute, array $oldInput)
    {
        $data = [];
        if (in_array($attributeType, [Attribute::TYPE_STRING, Attribute::TYPE_DECIMAL, Attribute::TYPE_INTEGER])) {
            $units = \Arr::get($oldInput, 'units', $attribute->units);
            $data['hasUnits'] = true;
            $data['units'] = $units;
        }

        return $data;
    }
}
