<?php

namespace App\Services\Catalog\Filter\Lens;


use Illuminate\Database\Eloquent\Builder;

final class CylinderSizeLens extends ClassicListLens
{

    public function modifyQuery($query, $lensData)
    {
        if (!is_array($lensData) || count($lensData) === 0) {
            return;
        }

        $attribute = $this->getAttribute();
        if (is_null($attribute)) {
            return;
        }

        $attrId = $attribute->id;
        $uniqueId = uniqid();
        $attrValuesAlias = "attr_single_val_{$attrId}_{$uniqueId}";

        $query->leftJoin(
            "attribute_single_values AS {$attrValuesAlias}",
            function ($join) use ($attrId, $attrValuesAlias) {
                $join->on(
                    'products.id',
                    '=',
                    "{$attrValuesAlias}.product_id"
                )->where("{$attrValuesAlias}.attribute_id", '=', $attrId);
            })
            ->join("attribute_allowed_values", "attribute_allowed_values.id", '=', "$attrValuesAlias.value_id")
            ->where('attribute_allowed_values.value_first_size_cylinder', $lensData[0]);

    }


    public function getVariants($query, $restrictedQuery, $lensData)
    {
        if (!is_array($lensData)) {
            $lensData = [];
        }

        $attribute = $this->getAttribute();
        if (is_null($attribute)) {
            return null;
        }

        $allowedIds = clone $query;
        $allowedIds = $allowedIds->join(
            'attribute_single_values',
            'attribute_single_values.product_id',
            '=',
            'products.id'
        )
            ->where('attribute_single_values.attribute_id', $attribute->id)
            ->select('attribute_single_values.value_id')
            ->distinct()
            ->pluck('value_id')
            ->toArray();
        $allowedValues = $this->allowedValueRepo->getAttributeValuesCylinderFirstSizeByIds($attribute, $allowedIds);
        $availableIdList = $this->getValueIds($restrictedQuery);


        $variants = [];
        foreach ($allowedValues as $value) {
            $checked = in_array($value->value_first_size_cylinder, $lensData);
            $available = in_array($value->value_first_size_cylinder, $availableIdList);
            $variants[] = [
                'value' => $value->value_first_size_cylinder,
                'checked' => $checked,
                'available' => $available || $checked ,
            ];
        }

        if (count($variants) === 0) {
            $variants = null;
        }

        return $variants;
    }

    protected function getValueIds(Builder $query): array
    {

//        dd(
//
//            $query
//                ->join("attribute_single_values AS attribute_values", "attribute_values.product_id", '=', "products.id")
//            ->join("attribute_allowed_values", "attribute_allowed_values.attribute_id", '=', "attribute_values.attribute_id")
//            ->where("attribute_values.attribute_id", $this->attribute->id)
//            ->whereRaw("attribute_values.value_id = attribute_allowed_values.id")
//            ->orderBy('attribute_allowed_values.value_first_size_cylinder')
//                ->select('attribute_allowed_values.value_first_size_cylinder')
//                ->distinct()->pluck('value_first_size_cylinder')->all()
//    );
        return $query
            ->join("attribute_single_values AS attribute_values", "attribute_values.product_id", '=', "products.id")
            ->join("attribute_allowed_values", "attribute_allowed_values.attribute_id", '=', "attribute_values.attribute_id")
            ->where("attribute_values.attribute_id", $this->attribute->id)
            ->whereRaw("attribute_values.value_id = attribute_allowed_values.id")
            ->orderBy('attribute_allowed_values.value_first_size_cylinder')
            ->select('attribute_allowed_values.value_first_size_cylinder')
            ->distinct()->pluck('value_first_size_cylinder')->all();

//            ->where("attribute_values.attribute_id", $this->attribute->id)
//            ->select('attribute_values.value_id')
//            ->distinct()->pluck('value_id')->all();
    }
}
