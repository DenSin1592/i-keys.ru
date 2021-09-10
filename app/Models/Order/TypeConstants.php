<?php

namespace App\Models\Order;

use App\Models\Features\ConstantsGetter;

class TypeConstants
{
    use ConstantsGetter;

    const FROM_SITE = 'from_site';
    const FAST = 'fast';
}