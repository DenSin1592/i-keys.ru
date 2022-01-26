<?php

namespace App\Services\Catalog\Filter\Lens;

use App\Models\Attribute;
use App\Services\Catalog\Filter\LensFeatures\ArrayLens;
use App\Services\Repositories\Attribute\AllowedValue\EloquentAllowedValueRepository;
use App\Services\Repositories\Attribute\EloquentAttributeRepository;
use Illuminate\Database\Eloquent\Builder;


class CylinderSeriesLens implements LensInterface
{
    use ArrayLens;
    use QueryHelpers;

    protected $attribute;
    private ?array $variantsCache;

    public function __construct(
        protected EloquentAttributeRepository $attrRepo,
        protected EloquentAllowedValueRepository $allowedValueRepo,
        protected string $attrCode1c
    ){}


    protected function getAttribute()
    {
        if (is_null($this->attribute)) {
            $attribute = $this->attrRepo->findCachedByCode1c($this->attrCode1c);
            if (is_null($attribute) || $attribute->attribute_type !== Attribute::TYPE_SINGLE) {
                $attribute = null;
            }
            $this->attribute = $attribute;
        }

        return $this->attribute;
    }


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
        )->whereIn("{$attrValuesAlias}.value_id", $lensData);
    }

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
                    )->where('asv1.attribute_id', Attribute\AttributeConstants::CYLINDER_SERIES_ID);
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
                'lens_key' => 'cylinder_series',
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
