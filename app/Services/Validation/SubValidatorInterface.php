<?php namespace App\Services\Validation;

use Illuminate\Validation\Validator;

interface SubValidatorInterface
{
    /**
     * Config validator.
     *
     * @param Validator $validator
     * @return mixed
     */
    public function configValidator(Validator $validator);
}
