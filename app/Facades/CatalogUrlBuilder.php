<?php namespace App\Facades;

use App\Services\UrlBuilder\Catalog\UrlBuilder;
use Illuminate\Support\Facades\Facade;

class CatalogUrlBuilder extends Facade
{
    protected static function getFacadeAccessor()
    {
        return UrlBuilder::class;
    }
}
