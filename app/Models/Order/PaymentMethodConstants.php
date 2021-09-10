<?php
namespace App\Models\Order;

use App\Models\Features\ConstantsGetter;

class PaymentMethodConstants
{
    use ConstantsGetter;

    const CASH = 'cash';
    const CASHLESS = 'cashless';

}