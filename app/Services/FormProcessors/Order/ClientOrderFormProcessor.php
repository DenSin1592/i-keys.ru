<?php

namespace App\Services\FormProcessors\Order;

use App\Models\Order;
use App\Models\Order\TypeConstants;

class ClientOrderFormProcessor extends OrderFormProcessor
{
    protected function prepareInputData(array $data): array
    {
        $data['cart_items'] = \Cart::items();

        return parent::prepareInputData($data);
    }

    public function createFast(array $data = [])
    {
        $data['type'] = TypeConstants::FAST;

        return $this->create($data);
    }

    protected function afterCreate(Order $order, array $data): void
    {
        parent::afterCreate($order, $data);

        \Cart::clear();
    }
}