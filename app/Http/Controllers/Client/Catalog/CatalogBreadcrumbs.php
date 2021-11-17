<?php

namespace App\Http\Controllers\Client\Catalog;

use App\Services\Breadcrumbs\Factory as Breadcrumbs;


trait CatalogBreadcrumbs
{

    protected function getBreadcrumbs(Breadcrumbs $breadcrumbs, array $categoryPath): \App\Services\Breadcrumbs\Container
    {
        $breadcrumbs = $breadcrumbs->init();
        $breadcrumbs->add('Главная', route('home'));
        foreach ($categoryPath as $category) {
            $breadcrumbs->add(
                $category->name,
                \UrlBuilder::getUrl($category)
            );
        }

        return $breadcrumbs;
    }
}
