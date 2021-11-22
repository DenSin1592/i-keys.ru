<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class CatalogHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\Catalog\CatalogHelper::class;
    }
}
