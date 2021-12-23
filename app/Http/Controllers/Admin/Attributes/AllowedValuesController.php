<?php namespace App\Http\Controllers\Admin\Attributes;

use App\Http\Controllers\Controller;
use App\Services\Repositories\Attribute\AllowedValue\EloquentAllowedValueRepository;

class AllowedValuesController extends Controller
{
    private $allowedValueRepository;

    public function __construct(EloquentAllowedValueRepository $allowedValueRepository)
    {
        $this->allowedValueRepository = $allowedValueRepository;
    }


    public function create()
    {
        $attributeCode1с = \Request::get('attributeCode1с');
        $allowedValueKey = \Request::get('key');
        $allowedValue = $this->allowedValueRepository->newInstance();
        $element = \View::make(
            'admin.attributes.form.allowed_values._element',
            [
                'allowedValueKey' => $allowedValueKey,
                'allowedValue' => $allowedValue,
                'code1c' => $attributeCode1с,
            ]
        )->render();

        return \Response::json(['element' => $element]);
    }
}
