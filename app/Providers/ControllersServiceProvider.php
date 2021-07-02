<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ControllersServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Fill controllers
        // use contextual bindings
        //        $this->app->when(PhotoController::class)
        //            ->needs(Filesystem::class)
        //            ->give(function () {
        //                return Storage::disk('local');
        //             });
    }
}
