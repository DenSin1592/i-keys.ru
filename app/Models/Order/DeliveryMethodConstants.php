<?php

namespace App\Models\Order;

use App\Models\Features\ConstantsGetter;

class DeliveryMethodConstants
{
    use ConstantsGetter;

    const SELF_DELIVERY = 'self';
    const COURIER = 'courier';
    const TRANSPORT_COMPANY = 'transport_company';

    public static function all(): array
    {
        return [
            self::SELF_DELIVERY,
            self::COURIER,
            self::TRANSPORT_COMPANY
        ];
    }

    /**
     * Get delivery methods thant needs delivery address
     * @return array
     */
    public static function withDeliveryAddress(): array
    {
        return [
            self::COURIER,
            self::TRANSPORT_COMPANY
        ];
    }

    public static function getMethodsForPayment($paymentMethod): array
    {
        switch ($paymentMethod) {
            case PaymentMethodConstants::CASH:
                return [
                    self::SELF_DELIVERY,
                    self::COURIER
                ];
            default:
                return self::all();
        }
    }
}
