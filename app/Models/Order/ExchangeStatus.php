<?php

namespace App\Models\Order;

use App\Models\Features\ExchangeStatus as FeaturesExchangeStatus;

/**
 * Trait ExchangeStatus
 * @package App\Models\ClientUser
 */
trait ExchangeStatus
{
    use FeaturesExchangeStatus;

    /**
     * Get fields that using in export
     *
     * @return array
     */
    protected static function getExportedFields(): array
    {
        return [
            'status',
            'payment_status',
            'client_id',
            'name',
            'email',
            'phone',
            'payment_method',
            'delivery_method',
            'postcode',
            'region_id',
            'city',
            'street',
            'building',
            'flat',
            'comment',
        ];
    }
}