<?php namespace App\Services\Validation\ProductTypePage;

use App\Models\ProductTypePage;
use App\Services\Validation\AbstractLaravelValidator;

class ProductTypePageLaravelValidator extends AbstractLaravelValidator
{
    protected function getRules()
    {
        $parentId = \Arr::get($this->data, 'parent_id');
        if (is_null($parentId)) {
            $parentId = 'NULL';
        }

        return [
            'parent_id' => ['nullable', 'exists:product_type_pages,id'],
            'name' => 'required',
            'alias' => [
                'required',
                "unique:product_type_pages,alias,{$this->currentId},id,parent_id,{$parentId}",
            ],
            'category_id' => ['required', 'exists:categories,id'],
            'publish' => 'boolean',
            'in_left_menu' => 'boolean',
            'position' => ['nullable', 'integer'],
            'product_list_way' => ['required', 'in:' . implode(',', array_keys(ProductTypePage::availableWays()))],
            'manual_products' => ['array', 'multi_exists:products,id'],
            'product_associations.*.*.position' => ['nullable', 'integer'],
        ];
    }

    public function getAttributeNames()
    {
        $attributeNames = [
            'product_associations.*.*.position' => trans('validation.attributes.position'),
        ];

        return $attributeNames;
    }
}
