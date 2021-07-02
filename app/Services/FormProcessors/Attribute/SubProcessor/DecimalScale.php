<?php namespace App\Services\FormProcessors\Attribute\SubProcessor;

use App\Models\Attribute;
use App\Services\FormProcessors\Attribute\SubProcessor;

class DecimalScale implements SubProcessor
{
    public function prepareInputData(array $data)
    {
        if (isset($data['decimal_scale'])) {
            $decimalScale = (int)$data['decimal_scale'];
            if ($decimalScale < 0) {
                $decimalScale = 0;
            } elseif ($decimalScale > 3) {
                $decimalScale = 3;
            }
            $data['decimal_scale'] = $decimalScale;
        }

        return $data;
    }

    public function save(Attribute $attribute, array $data)
    {
        // do nothing, default save
    }
}
