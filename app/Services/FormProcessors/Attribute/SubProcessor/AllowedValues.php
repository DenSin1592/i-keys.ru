<?php namespace App\Services\FormProcessors\Attribute\SubProcessor;

use App\Models\Attribute;
use App\Services\FormProcessors\Attribute\SubProcessor;
use App\Services\Repositories\Attribute\AllowedValue\EloquentAllowedValueRepository;

class AllowedValues implements SubProcessor
{
    private $allowedValueRepository;

    public function __construct(EloquentAllowedValueRepository $allowedValueRepository)
    {
        $this->allowedValueRepository = $allowedValueRepository;
    }


    public function prepareInputData(array $data)
    {
        return $data;
    }


    public function save(Attribute $attribute, array $data)
    {
        $valuesListData = \Arr::get($data, 'allowed_values', []);
        if (!is_array($valuesListData)) {
            $valuesListData = [];
        }

        $touchedIds = [];
        foreach ($valuesListData as $valueData) {
            $allowedValue = $this->allowedValueRepository->createOrUpdateForAttribute($attribute, $valueData);
            $touchedIds[$allowedValue->id] = true;
        }

        foreach ($attribute->allowedValues as $allowedValue) {
            if (!isset($touchedIds[$allowedValue->id])) {
                $this->allowedValueRepository->delete($allowedValue);
            }
        }
    }
}
