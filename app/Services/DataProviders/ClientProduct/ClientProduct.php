<?php

namespace App\Services\DataProviders\ClientProduct;

use App\Models\Attribute\AttributeConstants;
use App\Models\Product;


class ClientProduct
{
    private array $plugins = [];


    public function addPlugin(ClientProductPlugin $plugin): void
    {
        $this->plugins[] = $plugin;
    }


    public function getProductData(Product $product): array
    {
        $productData = ['product' => $product];
        foreach ($this->plugins as $plugin) {
            $productData = array_merge($productData, $plugin->getForProduct($product));
        }

        $productData['count_keys_in_set'] = $this->getCountKeys($productData);

        return $productData;
    }


    private function getCountKeys($productData): ?int
    {
        return isset($productData['attributesData'][AttributeConstants::MAIN][AttributeConstants::COUNT_KEYS_IN_SET_ID]['values'][0])
            ? (int) $productData['attributesData'][AttributeConstants::MAIN][AttributeConstants::COUNT_KEYS_IN_SET_ID]['values'][0]
            : null;
    }
}
