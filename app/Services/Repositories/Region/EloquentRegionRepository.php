<?php namespace App\Services\Repositories\Region;

use App\Models\Region;

class EloquentRegionRepository
{
    const POSITION_STEP = 10;

    public function all()
    {
        return Region::query()->orderBY('position', 'ASC')->get();
    }

    public function getVariants()
    {
        $variants = [];
        $variants[''] = trans('validation.attributes.not_chosen');
        foreach ($this->all() as $model) {
            $variants[$model->id] = $model->name;
        }

        return $variants;
    }

    public function findByName($name)
    {
        return Region::query()->where('name', $name)->first();
    }

    public function create(array $data)
    {
        if (\Arr::get($data, 'position') === null) {
            $maxPosition = Region::max('position');
            if (is_null($maxPosition)) {
                $maxPosition = 0;
            }

            $data['position'] = $maxPosition + self::POSITION_STEP;
        }

        return Region::create($data);
    }
}
