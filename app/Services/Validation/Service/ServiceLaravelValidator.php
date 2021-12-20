<?php namespace App\Services\Validation\Service;

use App\Models\Service;
use App\Services\Validation\AbstractLaravelValidator;

class ServiceLaravelValidator extends AbstractLaravelValidator
{
    protected function getRules()
    {
        $rules = [];
        $rules['name'] = ['required'];
        $rules['publish'] = 'boolean';
        $rules['position'] = ['nullable', 'integer'];
        $rules['price'] = ['nullable', 'numeric'];

        return $rules;
    }

    public function getAttributeNames()
    {
        return [
            'allowed_values.*.value' => trans('validation.attributes.value'),
            'allowed_values.*.position' => trans('validation.attributes.position'),
        ];
    }
}
