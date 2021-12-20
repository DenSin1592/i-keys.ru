<?php namespace App\Services\FormProcessors\Service\SubProcessor;

use App\Models\Service;
use App\Services\FormProcessors\Service\SubProcessor;
use App\Services\Repositories\Service\AllowedValue\EloquentAllowedValueRepository;

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


    public function save(Service $attribute, array $data)
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
