<?php

namespace App\Models\Order;

use App\Models\Features\ConstantsGetter;

class StatusConstants
{
    use ConstantsGetter;

    const NOVEL = 'novel';
    const CANCELLED = 'cancelled';
    const PROCESSED = 'processed';
    const TRANSFERRED_TO_DELIVERY_SERVICE = 'transferred_to_delivery_service';
    const CLOSED = 'closed';
}
