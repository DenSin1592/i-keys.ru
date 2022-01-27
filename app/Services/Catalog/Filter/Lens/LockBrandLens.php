<?php

namespace App\Services\Catalog\Filter\Lens;


final class LockBrandLens extends CategoryBrandLens
{
    protected function setLensWrapper(): void
    {
        $this->seriesLensWrapper = \App::make('catalog.filter_lens.lock_series');
    }
}
