<?php namespace App\Services\Repositories\Setting;

use App\Models\Setting;
use App\Models\SettingGroup;

/**
 * Class EloquentSettingRepository
 * @package  App\Services\Repositories\Setting
 */
class EloquentSettingRepository
{
    public function create(array $data)
    {
        return Setting::create($data);
    }

    public function update(Setting $setting, array $data)
    {
        return $setting->update($data);
    }

    public function findById($id)
    {
        return Setting::find($id);
    }

    public function findByKey($key)
    {
        return Setting::where('key', $key)->first();
    }

    public function newInstance(array $data = [])
    {
        return new Setting($data);
    }

    public function all()
    {
        return Setting::all();
    }
}
