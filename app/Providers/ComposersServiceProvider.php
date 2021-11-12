<?php namespace App\Providers;

use App\Services\Composers\AdminAlertComposer;
use App\Services\Composers\AdminMainMenuComposer;
use App\Services\Composers\ClientBottomMenuComposer;
use App\Services\Composers\ClientCityHeaderComposer;
use App\Services\Composers\ClientCityModalComposer;
use App\Services\Composers\ClientFooterCategoryComposer;
use App\Services\Composers\ClientHeaderCategoryComposer;
use App\Services\Composers\ClientHeaderCategoryMenuComposer;
use App\Services\Composers\ClientTopMenuComposer;
use App\Services\Composers\CurrentAdminUserComposer;
use Illuminate\Support\ServiceProvider;

class ComposersServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        \View::composers([
            AdminMainMenuComposer::class => 'admin.layouts._main_menu',
            AdminAlertComposer::class => 'admin.layouts._alerts',
            CurrentAdminUserComposer::class => ['admin.layouts._top_nav', 'client.layouts._auth_menu',],


            ClientTopMenuComposer::class => 'client.layouts._header',
            ClientBottomMenuComposer::class => 'client.layouts._footer',
//            ClientCityModalComposer::class => 'client.layouts._popups._location',
            ClientCityHeaderComposer::class => 'client.layouts._header',
        ]);
    }
}
