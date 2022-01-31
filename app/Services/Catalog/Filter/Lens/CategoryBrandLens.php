<?php

namespace App\Services\Catalog\Filter\Lens;

use App\Services\Catalog\Filter\Filter\FilterLensWrapper;


abstract class CategoryBrandLens extends ClassicListLens
{
    protected FilterLensWrapper $seriesLensWrapper;

    abstract protected function setLensWrapper(): void;


    public function getVariants($query, $restrictedQuery, $lensData)
    {
        $this->setLensWrapper();

        $variants = parent::getVariants($query, $restrictedQuery, $lensData);

        if (count($variants) === 0) {
            return null;
        }

        $seriesVariants = $this->seriesLensWrapper->getLens()->getVariantsCache();

        if (count($seriesVariants) === 0) {
            return $variants;
        }

        foreach ($variants as $keyVariants => $valueVariants) {
            foreach ($seriesVariants as $keySeries => $valueSeries) {
                if ($valueVariants['value'] === $valueSeries['brand_id']) {
                    $variants[$keyVariants]['there_is_series_variants'] = true;
                    if(($valueVariants['checked'])){
                        $variants[$keyVariants]['series_variants'][] = $valueSeries;
                    }

                    unset($seriesVariants[$keySeries]);
                }
            }
        }

        return $variants;
    }
}
