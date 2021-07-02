<?php namespace App\Providers;

use App\Services\Breadcrumbs\Factory;
use Illuminate\Support\ServiceProvider;

class BreadcrumbsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            Factory::class,
            function () {
                return new Factory();
            }
        );
    }
}
