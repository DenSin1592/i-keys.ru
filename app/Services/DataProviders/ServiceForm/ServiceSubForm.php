<?php namespace App\Services\DataProviders\ServiceForm;

use App\Models\Service;

/**
 * Interface ServiceSubForm
 * @package App\Services\DataProviders\ServiceForm
 */
interface ServiceSubForm
{
    /**
     * Provide data.
     *
     * @param Service $attribute
     * @param array $oldInput
     * @return array
     */
    public function provideDataFor(Service $attribute, array $oldInput);


    /**
     * Check if it is type data provider.
     *
     * @return bool
     */
    public function isTypeDataProvider();
}
