<?php

namespace App\Services\DataProviders\ProductsSeriesForm\Plugins;

use App\Services\DataProviders\ProductsSeriesForm\ProductsSeriesFormPlugin;


class Services implements ProductsSeriesFormPlugin
{
    public function getSubData($item, array $additionalData = []): array
    {
        $services = $item->services;

        return ['services' => $services];
    }
}
