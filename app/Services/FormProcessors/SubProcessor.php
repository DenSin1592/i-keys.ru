<?php

namespace App\Services\FormProcessors;


interface SubProcessor
{
    /**
     * Prepare input data for sub processor.
     */
    public function prepareInputData(array $data);

    /**
     * Save data for form processor.
     */
    public function save($model, array $data);
}
