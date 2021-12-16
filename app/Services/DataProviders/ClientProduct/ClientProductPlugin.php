<?php

namespace App\Services\DataProviders\ClientProduct;

use App\Models\Product;

interface ClientProductPlugin
{
    public function getForProduct(Product $product):array;
}