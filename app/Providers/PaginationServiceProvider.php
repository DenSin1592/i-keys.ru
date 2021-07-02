<?php namespace App\Providers;

use App\Services\Pagination\FlexPaginator;
use Illuminate\Support\ServiceProvider;

class PaginationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->when(FlexPaginator::class)
            ->needs('$availableLimits')
            ->give(function () {
                return $this->app->make('flex-paginator.available_limits');
            });

        $this->app->bind('flex-paginator.available_limits', function () {
            return [25, 50, 100, 250];
        });

    }
}
