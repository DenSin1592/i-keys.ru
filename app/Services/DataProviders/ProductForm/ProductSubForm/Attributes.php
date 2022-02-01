<?php namespace App\Services\DataProviders\ProductForm\ProductSubForm;

use App\Models\Attribute;
use App\Models\Product;
use App\Services\DataProviders\ProductForm\ProductSubForm;
use App\Services\Repositories\Attribute\EloquentAttributeRepository;
use App\Services\Repositories\Category\EloquentCategoryRepository;

class Attributes implements ProductSubForm
{
    private $categoryRepository;
    private $attributeRepository;

    public function __construct(
        EloquentCategoryRepository $categoryRepository,
        EloquentAttributeRepository $attributeRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->attributeRepository = $attributeRepository;
    }


    public function provideDataFor(Product $product, array $oldInput)
    {
        $category = $this->extractCategory($product, $oldInput);

        $attributes = $this->attributeRepository->allowedForCategory($category);
        $attributes->load(['allowedValues' => static function ($q){ $q->orderBy('attribute_allowed_values.value'); }]);
        $productValues = $this->attributeRepository->getValues($product, $attributes);
        $attributeListData = [];
        foreach ($productValues as $value) {
            $attributeData = ['attribute' => $value['attribute']];
            switch ($value['attribute']->attribute_type) {
                case Attribute::TYPE_STRING:
                case Attribute::TYPE_INTEGER:
                case Attribute::TYPE_DECIMAL:
                    $attributeData['data'] = !is_null($value['value']) ? $value['value']->value : null;
                    break;
                case Attribute::TYPE_SINGLE:
                    $attributeData['data'] = !is_null($value['value']) ? $value['value']->value_id : null;
                    $attributeData['allowedValues'] = ['' => '[не задано]'];
                    foreach ($value['attribute']->allowedValues as $allowedValue) {
                        $attributeData['allowedValues'][$allowedValue->id] = $allowedValue->value;
                    }
                    break;
                case Attribute::TYPE_MULTIPLE:
                    $attributeData['allowedValues'] = [];
                    foreach ($value['attribute']->allowedValues as $allowedValue) {
                        $attributeData['allowedValues'][$allowedValue->id] = $allowedValue->value;
                    }
                    $attributeData['data'] = [];
                    foreach ($value['values'] as $val) {
                        $attributeData['data'][] = $val->value_id;
                    }
                    break;
                default:
                    $attributeData = null;
                    break;
            }

            if (!is_null($attributeData)) {
                $attributeListData[] = $attributeData;
            }
        }

        return ['attributes' => $attributeListData];
    }


    /**
     * Extract category from product and input.
     *
     * @param Product $product
     * @param array $oldInput
     * @return \App\Models\Category
     */
    private function extractCategory(Product $product, array $oldInput)
    {
        $category = null;
        if (!is_null(\Arr::get($oldInput, 'category_id'))) {
            $category = $this->categoryRepository->findById(\Arr::get($oldInput, 'category_id'));
        }
        if (is_null($category)) {
            $category = $product->category;
        }

        return $category;
    }
}
