<?php namespace App\Services\Validation\Category;

use App\Models\Category;
use App\Services\Validation\AbstractLaravelValidator;

class CategoryLaravelValidator extends AbstractLaravelValidator
{
    protected function getRules()
    {
        $parentId = \Arr::get($this->data, 'parent_id');
        if (is_null($parentId)) {
            $parentId = 'NULL';
        }

        $rules = [];
        $rules['name'] = 'required';
        $rules['alias'] = "unique:categories,alias,{$this->currentId},id,parent_id,{$parentId}";
        $rules['parent_id'] = ['nullable', 'exists:categories,id'];

        return $rules;
    }
}
