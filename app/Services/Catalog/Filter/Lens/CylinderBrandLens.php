<?php

namespace App\Services\Catalog\Filter\Lens;

use App\Models\Attribute;
use App\Services\Catalog\Filter\LensFeatures\ArrayLens;
use App\Services\Repositories\Attribute\AllowedValue\EloquentAllowedValueRepository;
use App\Services\Repositories\Attribute\EloquentAttributeRepository;
use Illuminate\Database\Eloquent\Builder;



class CylinderBrandLens extends ClassicListLens
{
    public function getVariants($query, $restrictedQuery, $lensData)
    {
        $variants = parent::getVariants($query, $restrictedQuery, $lensData);

        if (count($variants) === 0) {
           return null;
        }

        $cylinderSeriesLensWrapper = \App::make('catalog.filter_lens.cylinder_series');
        $cylinderSeriesVariants = $cylinderSeriesLensWrapper->getLens()->getVariantsCache();

        if (count($cylinderSeriesVariants) === 0) {
            return $variants;
        }

        foreach ($variants as $keyVariants => $valueVariants) {
            foreach ($cylinderSeriesVariants as $keySeries => $valueSeries) {


                if ($valueVariants['value'] === $valueSeries['brand_id']) {
                    $variants[$keyVariants]['series_variants'][] = $valueSeries;
                    unset($cylinderSeriesVariants[$keySeries]);
                }
            }
        }

        return $variants;
    }


    protected function getValueIds(Builder $query): array
    {
        $table = $this->getValuesTable();

        return $query
            ->join("{$table} AS attribute_values", "attribute_values.product_id", '=', "products.id")
            ->where("attribute_values.attribute_id", $this->attribute->id)
            ->select('attribute_values.value_id')
            ->distinct()->pluck('value_id')->all();
    }

    protected function getValuesTable(): string
    {
        return 'attribute_single_values';
    }
}
