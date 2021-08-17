<?php

namespace App\Services\DataProviders\ClientProductList;

interface ClientProductListPlugin
{
    public function getForProductsList($products, array $additionalData = []): array;
}
