<?php namespace App\Services\FormProcessors\ProductTypePage;

use App\Models\ProductTypePage;

/**
 * Interface SubProcessor
 * @package App\Services\FormProcessors\ProductTypePage
 */
interface SubProcessor
{
    /**
     * Prepare input data for plugins.
     *
     * @param array $data
     * @return array
     */
    public function prepareInputData(array $data): array;

    /**
     * Save data for form processor.
     *
     * @param ProductTypePage $productTypePage
     * @param array $data
     */
    public function save(ProductTypePage $productTypePage, array $data);
}
