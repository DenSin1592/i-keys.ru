<?php namespace App\Services\Validation\Attribute;

use App\Models\Attribute;
use App\Services\Validation\AbstractLaravelValidator;

class AttributeLaravelValidator extends AbstractLaravelValidator
{
    protected function getRules()
    {
        return [
            'name' => 'required',
            'position' => ['nullable', 'integer'],
            'attribute_type' => ['required', 'in:' . implode(',', Attribute::getTypes())],
            'decimal_scale' => ['sometimes', 'required', 'integer', 'between:0,3'],
            'categories.*.id' => ['exists:categories,id'],
            'allowed_values.*.value' => ['sometimes', 'required'],
            'allowed_values.*.position' => ['nullable', 'integer'],
        ];
    }

    public function getAttributeNames()
    {
        return [
            'allowed_values.*.value' => trans('validation.attributes.value'),
            'allowed_values.*.position' => trans('validation.attributes.position'),
        ];
    }
}
