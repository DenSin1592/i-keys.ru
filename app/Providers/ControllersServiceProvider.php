<?php namespace App\Providers;

use App\Http\Controllers\Admin;
use App\Services\DataProviders\ExchangeView\ExchangeViewProvider;
use App\Services\Exchange\StatusHandler\ExportStatusHandler;
use App\Services\Exchange\StatusHandler\ImportStatusHandler;
use Illuminate\Support\ServiceProvider;

class ControllersServiceProvider extends ServiceProvider
{
    public function register()
    {

        $this->app->bind(
            Admin\ExchangeController::class,
            function () {
                return new Admin\ExchangeController(
                    $this->app->make('exchange.import_lock'),
                    $this->app->make('exchange.export_lock'),
                    $this->app->make(ImportStatusHandler::class),
                    $this->app->make(ExportStatusHandler::class),
                    $this->app->make(ExchangeViewProvider::class)
                );
            }
        );
        // Fill controllers
        // use contextual bindings
        //        $this->app->when(PhotoController::class)
        //            ->needs(Filesystem::class)
        //            ->give(function () {
        //                return Storage::disk('local');
        //             });
    }
}
