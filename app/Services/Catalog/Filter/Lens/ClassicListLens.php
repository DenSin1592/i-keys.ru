<?php namespace App\Services\Catalog\Filter\Lens;

use App\Models\Attribute;
use App\Services\Catalog\Filter\LensFeatures\ArrayLens;
use App\Services\Repositories\Attribute\AllowedValue\EloquentAllowedValueRepository;
use App\Services\Repositories\Attribute\EloquentAttributeRepository;
use Illuminate\Database\Eloquent\Builder;


/**
 * Class ClassicListLens
 * Lens to search by additional attribute with list type.
 *
 * @package App\Services\Catalog\Filter\Lens
 */
class ClassicListLens implements LensInterface
{
    use ArrayLens;
    use QueryHelpers;

    protected $attribute;

    public function __construct(
        protected EloquentAttributeRepository $attrRepo,
        protected EloquentAllowedValueRepository $allowedValueRepo,
        protected string $attrCode1c
    ) {}


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
        foreach ($allowedValues as $value) {
            $available = in_array($value->id, $availableIdList);
            $checked = in_array($value->id, $lensData) && $available;
            $variants[] = [
                'name' => $value->value,
                'value' => $value->id,
                'checked' => $checked,
                'available' => $available,
                'icon' => asset($value->getImgSourcePath('icon', null, 'no-image-40x40.png')),

//                'icon_sprite' => $value->getSpriteSvgHtml('class="filter-option-media" width="66" height="16"')
                'icon_sprite' => $this->getIconSpriteSvg($value)
            ];
        }

        if (count($variants) === 0) {
            $variants = null;
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

    private function getIconSpriteSvg(Attribute\AllowedValue $value): string
    {
        return match ($value->id){
            Attribute\AttributeConstants::CYLINDER_MECHANISM_TYPE_KEY_KEY => $value->getSpriteSvgHtml('class="filter-media" width="76" height="16"'),
            Attribute\AttributeConstants::CYLINDER_MECHANISM_TYPE_KEY_VERTUSHKA => $value->getSpriteSvgHtml('class="filter-media" width="57" height="16"',),
            Attribute\AttributeConstants::CYLINDER_MECHANISM_TYPE_KEY_SHTOCK => $value->getSpriteSvgHtml('class="filter-media" width="70" height="16"',),
            default => $value->getSpriteSvgHtml(),
        };
    }
}
