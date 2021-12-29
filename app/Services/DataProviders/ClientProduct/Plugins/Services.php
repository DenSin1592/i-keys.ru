<?php

namespace App\Services\DataProviders\ClientProduct\Plugins;

use App\Models\Product;
use App\Services\DataProviders\ClientProduct\ClientProductPlugin;


class Services implements ClientProductPlugin
{
    public function getForProduct(Product $product): array
    {
        $services = $product->getServices();

        return ['services' => $services];
    }
}
