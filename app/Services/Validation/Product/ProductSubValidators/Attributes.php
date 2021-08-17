<?php namespace App\Services\Validation\Product\ProductSubValidators;

use App\Models\Attribute;
use App\Services\Repositories\Attribute\EloquentAttributeRepository;
use App\Services\Validation\SubValidatorInterface;
use Illuminate\Validation\Validator;

/**
 * Class Attributes
 * @package App\Services\Validation\Product\ProductSubValidators
 */
class Attributes implements SubValidatorInterface
{
    private $attributeRepository;

    public function __construct(EloquentAttributeRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    public function configValidator(Validator $validator)
    {
        $attributesData = \Arr::get($validator->getData(), 'attributes');
        if (!is_array($attributesData)) {
            return;
        }

        $rulesResult = [];
        $namesResult = [];
        $attributes = $this->attributeRepository->all();
        $attributes->load('allowedValues');
        foreach ($attributes as $attribute) {
            $rules = [];
            switch ($attribute->attribute_type) {
                case Attribute::TYPE_DECIMAL:
                    $rules = ['nullable','numeric'];
                    break;
                case Attribute::TYPE_INTEGER:
                    $rules = ['nullable', 'integer'];
                    break;
                case Attribute::TYPE_STRING:
                    $rules = ['nullable', 'string'];
                    break;
                case Attribute::TYPE_SINGLE:
                    if ($attribute->allowedValues->count() > 0) {
                        $rules = ['nullable', 'in:' . implode(',', $attribute->allowedValues->pluck('id')->all())];
                    }
                    break;
                case Attribute::TYPE_MULTIPLE:
                    if ($attribute->allowedValues->count() > 0) {
                        $rules = ['multi_in:' . implode(',', $attribute->allowedValues->pluck('id')->all())];
                    }
                    break;
                default:
                    continue 2;
            }

            $rulesResult["attributes.{$attribute->id}"] = $rules;
            $namesResult["attributes.{$attribute->id}"] = $attribute->name;
        }

        $rules = array_merge($validator->getRules(), $rulesResult);
        $names = array_merge($validator->customAttributes, $namesResult);

        $validator->setRules($rules);
        $validator->setAttributeNames($names);
    }
}
