<?php

namespace App\Services\Catalog\Filter\Lens;

use Illuminate\Database\Eloquent\Builder;


final class CylinderSizeLens extends ClassicListLens
{
    public function modifyQuery($query, $lensData)
    {

       if(empty($lensData[0]) && empty($lensData[1])){
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
            ->join("attribute_allowed_values AS {$attrValuesAlias}_attr_all_val", "{$attrValuesAlias}_attr_all_val.id", '=', "$attrValuesAlias.value_id");

        if(!empty($lensData[0])){
            $query->where("{$attrValuesAlias}_attr_all_val.value_first_size_cylinder", $lensData[0]);
        }

        if(!empty($lensData[1])){
            $query->where("{$attrValuesAlias}_attr_all_val.value_second_size_cylinder", $lensData[1]);
        }
    }


    public function getVariants($query, $restrictedQuery, $lensData)
    {
        if(empty($lensData[0]) ){
            $lensData[0] = [];
        }
        $lensData[0] = [$lensData[0]];

        if(empty($lensData[1]) ){
            $lensData[1] = [];
        }
        $lensData[1] = [$lensData[1]];

        $restrictedQueryForFirstSize = clone $restrictedQuery;
        $this->modifyQuery($restrictedQueryForFirstSize, [null, $lensData[1][0]]);
        $firstSizeVariants = $this->getFirstSizeVariants(clone $query, $restrictedQueryForFirstSize, $lensData[0]);
        if(empty($firstSizeVariants)) {
            return null;
        }

        $restrictedQueryForSecondSize = clone $restrictedQuery;
        $this->modifyQuery($restrictedQueryForSecondSize, [$lensData[0][0], null]);
        $secondSizeVariants = $this->getSecondSizeVariants(clone $query, $restrictedQueryForSecondSize, $lensData[1]);
        if(empty($secondSizeVariants)) {
            return null;
        }

        return [
            'first_size' => $firstSizeVariants,
            'second_size' => $secondSizeVariants,
        ];
    }


    private function getFirstSizeVariants($query, $restrictedQuery, $lensData)
    {
        $attribute = $this->getAttribute();
        if (is_null($attribute)) {
            return null;
        }

        $allowedIds = $this->getAllowedIdsAttributeValue($query, $attribute->id);

        $allowedValues = $this->allowedValueRepo->getAttributeValuesCylinderFirstSizeByIds($attribute, $allowedIds);
        $availableIdList = $this->getFirstOrSecondSizeValueIds($restrictedQuery, 'value_first_size_cylinder');


        $variants = [];
        $notChecked = !empty($lensData);
        foreach ($allowedValues as $value) {
            $checked = $notChecked && in_array($value->value_first_size_cylinder, $lensData);
            $available = in_array($value->value_first_size_cylinder, $availableIdList);
            $variants[] = [
                'value' => $value->value_first_size_cylinder,
                'checked' => $checked,
                'available' => $available || $checked ,
            ];
        }

        return $variants;
    }


    private function getSecondSizeVariants($query, $restrictedQuery, $lensData)
    {
        $attribute = $this->getAttribute();
        if (is_null($attribute)) {
            return null;
        }

        $attribute = $this->getAttribute();
        if (is_null($attribute)) {
            return null;
        }

        $allowedIds = $this->getAllowedIdsAttributeValue($query, $attribute->id);
        $allowedValues = $this->allowedValueRepo->getAttributeValuesCylinderSecondSizeByIds($attribute, $allowedIds);
        $availableIdList = $this->getFirstOrSecondSizeValueIds($restrictedQuery, 'value_second_size_cylinder');


        $variants = [];
        $notChecked = !empty($lensData);
        foreach ($allowedValues as $value) {
            $checked = $notChecked && in_array($value->value_second_size_cylinder, $lensData);
            $available = in_array($value->value_second_size_cylinder, $availableIdList);
            $variants[] = [
                'value' => $value->value_second_size_cylinder,
                'checked' => $checked,
                'available' => $available || $checked ,
            ];
        }

        return $variants;
    }


    private function getFirstOrSecondSizeValueIds(Builder $query, string $column): array
    {
        return $query
            ->join("attribute_single_values AS attribute_values", "attribute_values.product_id", '=', "products.id")
            ->join("attribute_allowed_values", "attribute_allowed_values.attribute_id", '=', "attribute_values.attribute_id")
            ->where("attribute_values.attribute_id", $this->attribute->id)
            ->whereRaw("attribute_values.value_id = attribute_allowed_values.id")
            ->orderBy("attribute_allowed_values.{$column}")
            ->select("attribute_allowed_values.{$column}")
            ->distinct()->pluck($column)->all();
    }


    private function getAllowedIdsAttributeValue(Builder $query, int $attributeId): array
    {
        static $allowedIdsCache;

        if (isset($allowedIdsCache)) {
            return $allowedIdsCache;
        }

        $allowedIdsCache = $query
            ->join(
                'attribute_single_values',
                'attribute_single_values.product_id',
                '=',
                'products.id'
            )
            ->where('attribute_single_values.attribute_id', $attributeId)
            ->select('attribute_single_values.value_id')
            ->distinct()
            ->pluck('value_id')
            ->toArray();

        return $allowedIdsCache;
    }
}
