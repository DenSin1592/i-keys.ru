<?php

namespace App\Models\OrderItem;

use App\Models\Exchange\StatusConstants;
use App\Models\Order;

trait OrderExchangeStatus
{
    /**
     * Get fields that using in export
     *
     * @return array
     */
    private static function getExportedFields(): array
    {
        return [
            'count',
            'price',
            'code_1c',
        ];
    }

    public function isProductItem()
    {
        return !empty($this->code_1c) || !is_null($this->product);
    }

    protected static function bootOrderExchangeStatus()
    {
        self::created(
            function (self $orderItem) {
                if ($orderItem->isProductItem()) {
                    /** @var Order $order */
                    $order = $orderItem->order;
                    if ($order->exchange_status == StatusConstants::EXPORTED) {
                        $order->markExchangeStatusAsChanged();
                    }
                }
            }
        );

        self::updated(
            function (self $orderItem) {
                if ($orderItem->isProductItem()) {
                    $dirty = array_filter(
                        $orderItem->getDirty(),
                        function ($key) {
                            return in_array($key, self::getExportedFields());
                        },
                        ARRAY_FILTER_USE_KEY
                    );
                    if (count($dirty) > 0) {
                        $orderItem->order->markExchangeStatusAsChanged();
                    }
                }
            }
        );

        self::deleting(
            function (self $orderItem) {
                if ($orderItem->isProductItem()) {
                    /** @var Order $order */
                    $orderItem->order->markExchangeStatusAsChanged();
                }
            }
        );
    }
}