<?php

namespace App\Services\Catalog\Filter\Lens;

use App\Models\Attribute;


final class CylinderSeriesLens extends CategorySeriesLens
{
    protected const SERIES_ID = Attribute\AttributeConstants::CYLINDER_SERIES_ID;
    protected const LENS_KEY = 'cylinder_series';

}
