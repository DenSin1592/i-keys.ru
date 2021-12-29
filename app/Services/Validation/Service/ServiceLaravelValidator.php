<?php namespace App\Services\Validation\Service;

use App\Models\Service;
use App\Services\Validation\AbstractLaravelValidator;

class ServiceLaravelValidator extends AbstractLaravelValidator
{
    protected function getRules()
    {
        $rules = [];
        $rules['name'] = ['required'];
        $rules['alias'] = ['required', "unique:services,alias, {$this->currentId},id"];
        $rules['publish'] = 'boolean';
        $rules['position'] = ['nullable', 'integer'];
        $rules['price'] = ['nullable', 'numeric'];

        return $rules;
    }
}
