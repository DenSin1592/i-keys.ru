<?php

namespace App\Services\DataProviders\ClientProductList;

class ClientProductList
{
    /** @var ClientProductListPlugin[] */
    private $plugins = [];

    public function addPlugin(ClientProductListPlugin $plugin): void
    {
        $this->plugins[] = $plugin;
    }

    /**
     * Get product list data for products.
     *
     * @param $products
     * @param array $additionalData
     * @return array
     */
    public function getProductListData($products, array $additionalData = []): array
    {
        $additionalListData = [];
        foreach ($this->plugins as $plugin) {
            $additionalListData = array_merge(
                $additionalListData,
                $plugin->getForProductsList($products, $additionalData)
            );
        }

        return $this->buildProductListData($products, $additionalListData);
    }

    /**
     * Build product list data for products.
     *
     * @param $products
     * @param array $additionalListData
     * @return array
     */
    private function buildProductListData($products, array $additionalListData = []): array
    {
        $productListData = [];
        foreach ($products as $product) {
            $productData = ['product' => $product];
            foreach ($additionalListData as $dataKey => $listData) {
                $productData[$dataKey] = \Arr::get($listData, $product->id);
            }

            $productListData[] = $productData;
        }

        return $productListData;
    }
}
