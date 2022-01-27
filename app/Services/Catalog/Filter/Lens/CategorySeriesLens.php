<?php

namespace App\Services\Catalog\Filter\Lens;

use App\Models\Attribute;


abstract class CategorySeriesLens extends ClassicListLens
{
    private ?array $variantsCache;


    public function getVariants($query, $restrictedQuery, $lensData)
    {
        if(!empty($this->variantsCache)){
            return $this->variantsCache;
        }

        if (!is_array($lensData)) {
            $lensData = [];
        }

        $attribute = $this->getAttribute();
        if (is_null($attribute)) {
            return null;
        }


        $allowedValues = clone $query;
        $allowedValues = $allowedValues
            ->leftJoin(
                'attribute_single_values as asv1',
                function ($join) {
                    $join->on(
                        'products.id',
                        '=',
                        'asv1.product_id',
                    )->where('asv1.attribute_id', static::SERIES_ID);
                })
            ->leftJoin(
                'attribute_allowed_values as alv1',
                'asv1.value_id',
                '=',
                'alv1.id',
            )
            ->leftJoin(
                'attribute_single_values as asv2',
                static function ($join) {
                    $join->on(
                        'products.id',
                        '=',
                        'asv2.product_id',
                    )->where('asv2.attribute_id', Attribute\AttributeConstants::BRAND_ID);
                })
            ->leftJoin(
                'attribute_allowed_values as alv2',
                'asv2.value_id',
                '=',
                'alv2.id',
            )
            ->where('alv1.value', '<>', null)
            ->where('alv2.value', '<>', null)
            ->orderBy('alv1.value')
            ->select([
                'alv1.id as series_id',
                'alv1.value as series_value',
                'alv2.id as brand_id',
                'alv2.value as brand_value',
            ])
            ->distinct()
            ->get();

        $availableIdList = $this->getValueIds($restrictedQuery);

        $variants = [];
        foreach ($allowedValues as $value) {
            $available = in_array($value->series_id, $availableIdList);
            $checked = in_array($value->series_id, $lensData) && $available;
            $variants[] = [
                'name' => $value->series_value,
                'value' => $value->series_id,
                'checked' => $checked,
                'available' => $available,
                'brand_id' => $value->brand_id,
                'brand_name' => $value->brand_value,
                'lens_key' => static::LENS_KEY,
            ];
        }

        if (count($variants) === 0) {
            $variants = null;
        }

        $this->variantsCache = $variants;

        return  $this->variantsCache;
    }


    public function getVariantsCache(): ?array
    {
        return $this->variantsCache;
    }
}
