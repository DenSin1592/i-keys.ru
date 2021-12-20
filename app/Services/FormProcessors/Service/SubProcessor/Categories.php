<?php namespace App\Services\FormProcessors\Service\SubProcessor;

use App\Models\Attribute;
use App\Services\FormProcessors\Attribute\SubProcessor;

class Categories implements SubProcessor
{
    public function prepareInputData(array $data)
    {
        return $data;
    }


    public function save(Attribute $attribute, array $data)
    {
        $categoryIds = [];
        if (isset($data['categories']) && is_array($data['categories'])) {
            foreach ($data['categories'] as $category) {
                $categoryIds[] = \Arr::get($category, 'id');
            }
        }
        $syncData = $attribute->categories()->sync($categoryIds);
        $changed = false;
        foreach ($syncData as $syncD) {
            if (count($syncD) > 0) {
                $changed = true;
                break;
            }
        }

        if ($changed) {
            $attribute->touch();
        }
    }
}
