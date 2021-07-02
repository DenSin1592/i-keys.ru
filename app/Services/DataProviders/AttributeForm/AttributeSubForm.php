<?php namespace App\Services\DataProviders\AttributeForm;

use App\Models\Attribute;

/**
 * Interface AttributeSubForm
 * @package App\Services\DataProviders\AttributeForm
 */
interface AttributeSubForm
{
    /**
     * Provide data.
     *
     * @param Attribute $attribute
     * @param array $oldInput
     * @return array
     */
    public function provideDataFor(Attribute $attribute, array $oldInput);


    /**
     * Check if it is type data provider.
     *
     * @return bool
     */
    public function isTypeDataProvider();
}
