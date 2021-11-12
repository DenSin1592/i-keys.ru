<?php

namespace App\Providers;

use App\Services\Repositories\Subdomain\EloquentSubdomainRepository;
use App\Services\Subdomains\SubdomainsHelper;
use Illuminate\Support\ServiceProvider;
use App\Services\Subdomains\UrlHelper;


class SubdomainsServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton(SubdomainsHelper::class, function () {
            return new SubdomainsHelper(
//                $this->app->make('App\Services\Subdomains\Config'),
//                $this->app->make('App\Services\Subdomains\Fields\FormHelper'),
//                $this->app->make('App\Services\Subdomains\Fields\Storage'),
                $this->app->make(EloquentSubdomainRepository::class),
//                $this->app->make('App\Services\Repositories\SubdomainField\SubdomainFieldRepositoryInterface'),
                $this->app->make(UrlHelper::class),
//                $this->app->make('App\Services\Subdomains\SeoHelper')
            );
        });

        /*$this->app->singleton('App\Services\Subdomains\Config', function () {
            $config = new Config;

            $config->addFieldsFor(
                new HomePage(),
                ['header', 'content', 'meta_title', 'meta_description', 'meta_keywords']
            );
            $config->addFieldsFor(
                new TextPage(),
                ['header', 'content', 'meta_title', 'meta_description', 'meta_keywords']
            );
            $config->addFieldsFor(
                new ProductTypePage(),
                ['header', 'content', 'content_bottom', 'content_tricky', 'meta_title', 'meta_description', 'meta_keywords']
            );
            $config->addFieldsFor(
                new SalePage(),
                []
            );

            $config->addFieldsFor(
                new CatalogCategory(),
                [
                    'header',
                    'name_home_page',
                    'content_home_page',
                    'content',
                    'content_bottom',
                    'meta_title',
                    'meta_description',
                    'meta_keywords'
                ]
            );
            $config->addFieldsFor(
                new CatalogProduct(),
                [
                    'header',
                    'short_content',
                    'content',
                    'meta_title',
                    'meta_description',
                    'meta_keywords'
                ]
            );

            return $config;
        });*/
    }
}
