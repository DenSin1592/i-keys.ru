<?php namespace App\Services\Validation\Review;

use App\Services\Validation\AbstractLaravelValidator;
use Illuminate\Validation\Validator;

abstract class BasicReviewValidator extends AbstractLaravelValidator
{
    protected function getRules()
    {
        return [
            'name' => 'required',
            'email' => 'email',
            'product_id' => 'exists:products,id',
            'content' => 'required',
        ];
    }

    protected function configValidator(Validator $validator)
    {
        parent::configValidator($validator);

        $validator->sometimes(
            'product_id',
            'required',
            function () {
                return empty($this->currentId);
            }
        );
    }
}
