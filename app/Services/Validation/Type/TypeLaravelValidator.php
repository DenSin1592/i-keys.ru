<?php namespace App\Services\Validation\Type;

use App\Services\Validation\AbstractLaravelValidator;

class TypeLaravelValidator extends AbstractLaravelValidator
{
    protected function getRules()
    {
        $parentId = \Arr::get($this->data, 'parent_id');
        if (is_null($parentId)) {
            $parentId = 'NULL';
        }

        $rules = [];
        $rules['name'] = 'required';
        $rules['alias'] = "unique:types,alias,{$this->currentId},id,parent_id,{$parentId}";

        $rules['parent_id'] = ['nullable', 'exists:types,id'];
        $rules['category_id'] = ['required', 'exists:categories,id'];

        return $rules;
    }
}
