<?php

namespace App\Services\DataProviders\ClientProductList;

class ClientProductList
{
    private array $plugins = [];

    public function addPlugin(ClientProductListPlugin $plugin): void
    {
        $this->plugins[] = $plugin;
    }


    public function getProductListData($products, array $additionalData = []): array
    {
        $additionalListData = [];
        foreach ($this->plugins as $plugin) {
            $additionalListData = array_merge(
                $additionalListData,
                $plugin->getForProductsList($products, $additionalData)
            );
        }

        $productListData = $this->buildProductListData($products, $additionalListData);

        return $productListData;
    }


    private function buildProductListData($products, array $additionalListData = []): array
    {
        $productListData = [];

        foreach ($products as $product) {
            $productData = ['product' => $product];
            foreach ($additionalListData as $dataKey => $listData) {
                $productData[$dataKey] = $listData[$product->id] ?? null;
            }

            $productListData[] = $productData;
        }

        return $productListData;
    }
}
