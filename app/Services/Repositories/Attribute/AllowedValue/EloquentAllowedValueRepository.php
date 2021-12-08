<?php namespace App\Services\Repositories\Attribute\AllowedValue;

use App\Models\Attribute;
use App\Models\Attribute\AllowedValue;
use Illuminate\Database\Eloquent\Collection;

class EloquentAllowedValueRepository
{
    const POSITION_STEP = 10;


    public function newInstance(array $data = [])
    {
        return new AllowedValue($data);
    }


    public function allForAttribute(Attribute $attribute)
    {
        return $attribute->allowedValues()->orderBy('position')->get();
    }

    /**
     * @param Attribute $attribute
     * @param $value
     * @return AllowedValue|null
     */
    public function findForAttributeByValueOrCreate(Attribute $attribute, $value)
    {
        $allowedValue = $attribute->allowedValues()->where('value', $value)->first();
        if (is_null($allowedValue)) {
            $allowedValue = new AllowedValue();
            $allowedValue->attribute()->associate($attribute);
            $data = ['value' => $value,];

            $allowedValue->fill($data);
            $allowedValue->save();
            $attribute->touch();
        }

        return $allowedValue;
    }

    public function createOrUpdateForAttribute(Attribute $attribute, array $data = [])
    {
        $id = \Arr::get($data, 'id');
        $allowedValue = $attribute->allowedValues()->where('id', $id)->first();
        if (is_null($allowedValue)) {
            $allowedValue = new AllowedValue();
            $allowedValue->attribute()->associate($attribute);
        }

        if (\Arr::get($data, 'position') === null) {
            $maxPosition = $attribute->allowedValues()->max('position');
            if (is_null($maxPosition)) {
                $maxPosition = 0;
            }
            $data['position'] = $maxPosition + self::POSITION_STEP;
        }

        $allowedValue->fill($data);
        if ($allowedValue->isDirty()) {
            $attribute->touch();
        }
        $allowedValue->save();

        return $allowedValue;
    }


    public function delete(AllowedValue $allowedValue)
    {
        return $allowedValue->delete();
    }


    public function forAttributeByIds(Attribute $attribute, array $ids)
    {
        if (count($ids) === 0) {
            return Collection::make([]);
        }

        $query = $attribute->allowedValues()->whereIn('id', $ids);
        $this->scopeOrdered($query, $this->getOrderCastTypeForAttribute($attribute));

        return $query->get();
    }


    public function getAttributeValuesCylinderFirstSizeByIds(Attribute $attribute, array $ids)
    {
        if (count($ids) === 0) {
            return Collection::make([]);
        }

        $query = $attribute->allowedValues()->whereIn('id', $ids);
        $query->select('attribute_allowed_values.value_first_size_cylinder')->distinct();
        $query->orderBy('attribute_allowed_values.value_first_size_cylinder');

        return $query->get();
    }


    public function getAttributeValuesCylinderSecondSizeByIds(Attribute $attribute, array $ids)
    {
        if (count($ids) === 0) {
            return Collection::make([]);
        }

        $query = $attribute->allowedValues()->whereIn('id', $ids);
        $query->select('attribute_allowed_values.value_second_size_cylinder')->distinct();
        $query->orderBy('attribute_allowed_values.value_second_size_cylinder');

        return $query->get();
    }


    private function scopeOrdered($query, string $castAsType = null)
    {
        if (!is_null($castAsType)) {
            $query->orderByRaw("CAST(attribute_allowed_values.value AS {$castAsType}) ASC");
        }

        return $query->orderBy('attribute_allowed_values.value', 'ASC');
    }


    private function getOrderCastTypeForAttribute(Attribute $attribute)
    {
        if (isset($attribute->code_1c)) {
            $attributeCodes1GroupByCastTypeForOrdered = $this->getAttributeCodes1CGroupByCastTypeForOrdered();
            foreach ($attributeCodes1GroupByCastTypeForOrdered as $castAsType => $attributeCodes) {
                if (in_array($attribute->code_1c, $attributeCodes)) {
                    return $castAsType;
                }
            }
        }

        return null;
    }


    private function getAttributeCodes1CGroupByCastTypeForOrdered()
    {
        return [
            'UNSIGNED' => ['000000013']
        ];
    }
}
