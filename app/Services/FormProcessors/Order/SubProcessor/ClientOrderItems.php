<?php

namespace App\Services\FormProcessors\Order\SubProcessor;

use App\Services\Cart\CartItem;
use App\Services\Cart\CartItemService;

class ClientOrderItems extends OrderItems
{
    public function prepareInputData(array $inputData): array
    {
        $orderItems = \Arr::get($inputData, 'cart_items', []);

        $preparedOrderItems = [];
        foreach ($orderItems as $orderItem) {
            $preparedOrderItems[] = $this->getOrderItemDataFor($orderItem);
            foreach ($orderItem->getServices() as $service){
                $preparedOrderItems[] = $this->getOrderItemServiceData($service);
            }
        }

        unset($inputData['cart_items']);
        \Arr::set($inputData, 'order_items', $preparedOrderItems);

        return $inputData;
    }

    /**
     * Get order item data.
     *
     * @param CartItem $cartItem
     * @return array
     */
    private function getOrderItemDataFor(CartItem $cartItem)
    {
        $product = $cartItem->getProduct();

        return [
            'name' => $product->name,
            'product_id' => $product->id,
            'code_1c' => $product->code_1c,
            'price' => $cartItem->getPrice(),
            'count' => $cartItem->getCount(),
        ];
    }


    private function getOrderItemServiceData(CartItemService $cartItem)
    {
        $service = $cartItem->getService();

        return [
            'name' => $service->name,
            'service_id' => $service->id,
            'code_1c' => $service->code_1c,
            'price' => $cartItem->getPrice() ?? 0 ,
            'count' => $cartItem->getCount(),
        ];
    }
}
