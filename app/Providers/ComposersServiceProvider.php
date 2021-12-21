<?php

namespace App\Providers;

use App\Services\Composers\AdminAlertComposer;
use App\Services\Composers\AdminMainMenuComposer;
use App\Services\Composers\ClientBottomMenuComposer;
use App\Services\Composers\ClientCityHeaderComposer;
use App\Services\Composers\ClientFooterCategoryComposer;
use App\Services\Composers\ClientHeaderCartComposer;
use App\Services\Composers\ClientHeaderCategoryMenuComposer;
use App\Services\Composers\ClientTopMenuComposer;
use App\Services\Composers\CurrentAdminUserComposer;
use Illuminate\Support\ServiceProvider;


class ComposersServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton(ClientTopMenuComposer::class, ClientTopMenuComposer::class);
        $this->app->singleton(ClientHeaderCategoryMenuComposer::class, ClientHeaderCategoryMenuComposer::class);

        \View::composers([
            AdminMainMenuComposer::class => 'admin.layouts._main_menu',
            AdminAlertComposer::class => 'admin.layouts._alerts',
            CurrentAdminUserComposer::class => ['admin.layouts._top_nav', 'client.layouts._auth_menu',],


            ClientTopMenuComposer::class => ['client.layouts._header', 'client.layouts._offcanvas'],
            ClientBottomMenuComposer::class => 'client.layouts._footer',
//            ClientCityModalComposer::class => 'client.layouts._popups._location',
//            ClientCityHeaderComposer::class => ['client.layouts._header', 'client.layouts._offcanvas'],
            ClientHeaderCategoryMenuComposer::class => ['client.layouts._header', 'client.layouts._offcanvas'],
            ClientFooterCategoryComposer::class => 'client.layouts._footer',
            ClientHeaderCartComposer::class => ['client.layouts._header', 'client.layouts._offcanvas'],
        ]);
    }
}
