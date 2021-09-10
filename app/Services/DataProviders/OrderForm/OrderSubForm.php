<?php namespace App\Services\DataProviders\OrderForm;

use App\Models\Order;

/**
 * Class OrderSubForm
 * @package App\Services\DataProviders\OrderForm
 */
interface OrderSubForm
{
    /**
     * Provide data.
     *
     * @param Order $order
     * @param array $oldInput
     * @return mixed
     */
    public function provideDataFor(Order $order, array $oldInput);
}
