<?php namespace App\Services\FormProcessors\Product;

use App\Models\Product;

/**
 * Interface SubProcessor
 * Sub processor for product form.
 *
 * @package App\Services\FormProcessors\Product
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
     * @param Product $product
     * @param array $data
     */
    public function save(Product $product, array $data);
}
