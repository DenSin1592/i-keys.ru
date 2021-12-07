<?php

namespace App\Services\Catalog\Filter\Lens;


final class SecurityClassLens extends ClassicListLens
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
            }
        )->whereRaw("{$attrValuesAlias}.value_id in (SELECT `attribute_allowed_values`.`id` FROM `attribute_allowed_values` WHERE `attribute_allowed_values`.`attribute_id` = $attrId and `attribute_allowed_values`.`value` >= (SELECT `attribute_allowed_values`.`value` FROM `attribute_allowed_values` WHERE `attribute_allowed_values`.`id` = $lensData[0]))");
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
        $allowedValues = $this->allowedValueRepo->forAttributeByIds($attribute, $allowedIds);

        $availableIdList = $this->getValueIds($restrictedQuery);

        $variants = [];
        $indexLastAviableVariant = -1;
        foreach ($allowedValues as $key => $value) {
            $checked = in_array($value->id, $lensData);
            $available = in_array($value->id, $availableIdList);
            $variants[] = [
                'name' => $value->value . ' и выше',
                'value' => $value->id,
                'checked' => $checked,
                'available' => $available || $checked /*|| $beforeFirstAvailable*/,
            ];

            if($variants[$key]['available']){
                $indexLastAviableVariant = $key;
            }
        }

        if (count($variants) === 0) {
            $variants = null;
        }

        for($i = 0; $i <= $indexLastAviableVariant; $i++){
            $variants[$i]['available'] = true;
        }

        return $variants;
    }
}
