<?php namespace App\Services\FormProcessors\Order;

use App\Models\Order;

/**
 * Class SubProcessor
 * @package App\Services\FormProcessors\Order
 */
interface SubProcessor
{
    /**
     * Prepare input data for sub processor.
     *
     * @param array $data
     * @return array
     */
    public function prepareInputData(array $data): array;

    /**
     * Save data for form processor after creating of order.
     *
     * @param Order $order
     * @param array $data
     * @return void
     */
    public function saveAfterCreate(Order $order, array $data): void;

    /**
     * Save data for form processor after updating of order.
     *
     * @param Order $order
     * @param array $data
     * @return bool
     */
    public function saveAfterUpdate(Order $order, array $data): bool;
}
