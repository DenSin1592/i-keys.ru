<?php namespace App\Services\Validation\Product;

use App\Services\Validation\AbstractLaravelValidator;

class ProductLaravelValidator extends AbstractLaravelValidator
{
    protected function getRules()
    {
        $categoryId = \Arr::get($this->data, 'category_id');
        if (is_null($categoryId)) {
            $categoryId = 'NULL';
        }

        $rules = [];
        $rules['alias'] = "unique:products,alias,{$this->currentId},id,category_id,{$categoryId}";

        return $rules;
    }
}
