<?php namespace App\Services\DataProviders\ProductForm;

use App\Models\Product;

class ProductForm
{
    /** @var ProductSubForm[] */
    private $subFormList = [];

    /**
     * Add sub form.
     *
     * @param ProductSubForm $subForm
     */
    public function addSubForm(ProductSubForm $subForm)
    {
        $this->subFormList[] = $subForm;
    }

    public function provideDataFor(Product $product, array $oldInput)
    {
        $data = ['product' => $product];
        foreach ($this->subFormList as $subForm) {
            $subFormData = $subForm->provideDataFor($product, $oldInput);
            $data = array_replace($data, $subFormData);
        }

        return $data;
    }
}
