<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\Pagination\PrettyPaginator\Factory as PrettyPaginatorFactory;

class PrettyPaginatorFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PrettyPaginatorFactory::class;
    }
}
