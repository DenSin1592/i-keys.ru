<?php

namespace App\Providers;

use App\Services\Seo\MetaHelper;
use Illuminate\Support\ServiceProvider;

class SeoServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->singleton(MetaHelper::class, function () {
            $metaHelper = new MetaHelper();

            // Default rule
            $metaHelper->addRule(function (array $metaData, array $input) {

                if (empty($metaData['meta_title'])) {
                    $metaData['meta_title'] =
                        "{$metaData['h1']} - Интернет-магазин дверных замков и фурнитуры - Замки-Ключи";
                }

                if (empty($metaData['meta_description'])) {
                    $metaData['meta_description'] =
                        "{$metaData['h1']} - Интернет-магазин дверных замков и фурнитуры - Замки-Ключи";
                }

                if (empty($metaData['meta_keywords'])) {
                    $metaData['meta_keywords'] = \Str::lower($metaData['h1']) . ', Замки-Ключи, замки, ручки, фурнитура';
                }

                return $metaData;
            });

            return $metaHelper;
        });
    }
}
