<?php

namespace App\Services\DataProviders\ProductsSeriesForm\Plugins;

use App\Services\DataProviders\ProductsSeriesForm\ProductsSeriesFormPlugin;


class Products implements ProductsSeriesFormPlugin
{
    public function getSubData($item, array $additionalData = []): array
    {
        return ['products' => $item->productsForSingle];
    }
}
