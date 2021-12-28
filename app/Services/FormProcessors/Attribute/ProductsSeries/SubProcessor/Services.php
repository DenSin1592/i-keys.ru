<?php

namespace App\Services\FormProcessors\Attribute\ProductsSeries\SubProcessor;

use App\Services\FormProcessors\SubProcessor;


class Services implements SubProcessor
{

    public function prepareInputData(array $data): array
    {
        return $data;
    }


    public function save($model, array $data)
    {
        $subModelsData = \Arr::get($data, 'services', []);
        if (!is_array($subModelsData)) {
            return;
        }

        $subModelsIds = [];
        foreach ($subModelsData as $subModelData) {
            $subModelsIds[] = $subModelData['id'];
        }

        $changes = $model->services()->sync($subModelsIds);
        $changed = false;
        foreach ($changes as $changedIds) {
            if (count($changedIds) > 0) {
                $changed = true;
                break;
            }
        }
        if ($changed) {
            $model->touch();
        }
    }
}
