<?php

namespace App\Services\Catalog\Filter\Lens;


final class CylinderBrandLens extends CategoryBrandLens
{
    protected function setLensWrapper(): void
    {
        $this->seriesLensWrapper = \App::make('catalog.filter_lens.cylinder_series');
    }
}
