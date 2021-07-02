<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Setting
 * Facade for setting getter.
 * @package Facade
 */
class Setting extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'setting';
    }
}
