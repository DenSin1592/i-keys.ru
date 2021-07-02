<?php namespace App\Models;

use App\Models\Features\ArrayAttribute;
use App\Models\SettingGroup;

/**
 * Class Setting
 * @package App\Models
 */
class Setting extends \Eloquent
{
    protected $casts = [
        'array_value' => 'array',
    ];

    protected $fillable = ['key', 'value', 'array_value',];
}
