<?php namespace App\Services\FormProcessors\Attribute;

use App\Models\Attribute;

/**
 * Interface SubProcessor
 * Sub processor for attribute form.
 *
 * @package App\Services\FormProcessors\Attribute
 */
interface SubProcessor
{
    /**
     * Prepare input data for sub processor.
     *
     * @param array $data
     * @return array
     */
    public function prepareInputData(array $data);

    /**
     * Save data for form processor.
     *
     * @param Attribute $attribute
     * @param array $data
     */
    public function save(Attribute $attribute, array $data);
}
