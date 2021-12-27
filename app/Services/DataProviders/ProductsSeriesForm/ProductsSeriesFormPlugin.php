<?php

namespace App\Services\DataProviders\ProductsSeriesForm;

interface ProductsSeriesFormPlugin
{
    public function getSubData($item, array $additionalData = []): array;
}
