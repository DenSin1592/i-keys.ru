<?php

namespace App\Providers;

use App\Services\Cart\Cart;
use App\Services\Repositories\Product\EloquentProductRepository;
use App\Services\Storage\CookieCartStorage;
use App\Services\Storage\ICardStorage;
use App\Services\Storage\SessionCartStorage;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(
            Cart::class,
            function (Application $app) {
                return new Cart(
                    $app->make(EloquentProductRepository::class),
                    $app->make(ICardStorage::class)
                );
            }
        );

        $this->app->singleton(ICardStorage::class,
        function() {
            return new CookieCartStorage();
        });
    }
}
