<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;


class UrlBuilder extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\UrlBuilder\UrlBuilder::class;
    }
}
