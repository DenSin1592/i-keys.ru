<?php

namespace App\Models\Exchange;

use App\Models\Features\ConstantsGetter;

class StatusConstants
{
    use ConstantsGetter;

    const EXPORTED = 'exported';
    const NEW = 'new';
    const CHANGED = 'changed';
}