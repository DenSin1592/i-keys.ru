<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class TypeContainer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'structure_types.types';
    }
}
