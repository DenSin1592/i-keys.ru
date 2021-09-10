<?php

namespace App\Models\Order;

use App\Models\Features\ConstantsGetter;

class PaymentStatusConstants
{
    use ConstantsGetter;

    const UNPAID = 'unpaid';
    const PAID = 'paid';
    const PARTLY_PAID = 'partly_paid';
}