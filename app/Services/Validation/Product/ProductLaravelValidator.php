<?php namespace App\Services\Validation\Product;

use App\Services\Validation\AbstractLaravelValidator;
use App\Services\Validation\SubValidatorInterface;
use Illuminate\Validation\Validator;

class ProductLaravelValidator extends AbstractLaravelValidator
{
    /** @var SubValidatorInterface[] */
    private $subValidatorList = [];

    protected function getRules()
    {
        $rules = [];
        $rules['name'] = ['required_without:code_1c'];
        $rules['code_1c'] = ['nullable', "unique:products,code_1c,{$this->currentId}"];
        $rules['category_id'] = ['required', "exists:categories,id"];
        $rules['publish'] = 'boolean';
        $rules['position'] = ['nullable', 'integer'];
        $rules['price'] = ['nullable', 'numeric'];
        $rules['images.*.image_file'] = [
            'nullable',
            'local_or_remote_file:jpeg,jpg,png',
            'required_if:images.*.image__exists,0'
        ];
        $rules['images.*.position'] = ['nullable', 'integer'];
        $rules['images.*.publish'] = 'boolean';
        $rules['related_products.*.product_id'] = ['required', "exists:products,id"];

        return $rules;
    }

    protected function getMessages()
    {
        return [
            'images.*.image_file.required_if' =>
                'Поле ' . trans('validation.attributes.image_file') . ' обязательно для заполнения.',
        ];
    }

    public function getAttributeNames()
    {
        $attributeNames = [
            'related_products.*.product_id' => trans('validation.attributes.product_id'),
            'images.*.image_file' => trans('validation.attributes.image_file'),
            'images.*.position' => trans('validation.attributes.position'),
            'images.*.publish' => trans('validation.attributes.publish'),
        ];

        return $attributeNames;
    }

    /**
     * Add sub validator.
     *
     * @param SubValidatorInterface $subValidator
     */
    public function addSubValidator(SubValidatorInterface $subValidator)
    {
        $this->subValidatorList[] = $subValidator;
    }

    protected function configValidator(Validator $validator)
    {
        parent::configValidator($validator);

        foreach ($this->subValidatorList as $subValidator) {
            $subValidator->configValidator($validator);
        }
    }
}
