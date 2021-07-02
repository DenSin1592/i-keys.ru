<?php namespace App\Services\DataProviders\ProductForm;

use App\Models\Product;

/**
 * Interface ProductSubForm
 * @package App\Services\DataProviders\ProductForm
 */
interface ProductSubForm
{
    /**
     * Provide data.
     *
     * @param Product $product
     * @param array $oldInput
     * @return array
     */
    public function provideDataFor(Product $product, array $oldInput);
}
