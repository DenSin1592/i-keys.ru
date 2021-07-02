<?php namespace App\Services\Validation\Attribute;

use App\Models\Attribute;
use App\Services\Validation\AbstractLaravelValidator;

class AttributeLaravelValidator extends AbstractLaravelValidator
{
    protected function getRules()
    {
        return [
            'name' => 'required',
            'attribute_type' => ['required', 'in:' . implode(',', Attribute::getTypes())],
            'categories' => ['exists:categories,id'],
            'allowed_values.*.value' => ['sometimes', 'required'],
        ];
    }

    public function getAttributeNames()
    {
        return [
            'allowed_values.*.value' => trans('validation.attributes.value'),
        ];
    }
}
