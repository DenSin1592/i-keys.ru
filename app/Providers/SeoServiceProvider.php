<?php namespace App\Providers;

use App\Services\Seo\MetaHelper;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class SeoServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MetaHelper::class, function (Application $app) {
            $metaHelper = new MetaHelper();

            // Default rule
            $metaHelper->addRule(function (array $metaData, array $input) {
                return $metaData;
            });

            return $metaHelper;
        });
    }
}
