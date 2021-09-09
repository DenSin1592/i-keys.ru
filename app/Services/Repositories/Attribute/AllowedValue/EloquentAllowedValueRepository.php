<?php namespace App\Services\Repositories\Attribute\AllowedValue;

use App\Models\Attribute;
use App\Models\Attribute\AllowedValue;

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
}
