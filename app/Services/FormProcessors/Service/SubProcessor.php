<?php namespace App\Services\FormProcessors\Service;

use App\Models\Service;

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
     * @param Service $attribute
     * @param array $data
     */
    public function save(Service $attribute, array $data);
}
