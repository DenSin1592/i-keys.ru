<?php

namespace App\Services\Catalog\Filter\Lens;

use App\Models\Attribute;


final class LockSeriesLens extends CategorySeriesLens
{
    protected const SERIES_ID = Attribute\AttributeConstants::LOCK_SERIES_ID;
    protected const LENS_KEY = 'series';
}
