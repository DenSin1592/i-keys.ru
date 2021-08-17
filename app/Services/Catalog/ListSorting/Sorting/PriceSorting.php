<?php namespace App\Services\Catalog\ListSorting\Sorting;

use App\Services\Catalog\ListSorting\Sorting;

class PriceSorting extends Sorting
{
    public function modifyQuery($query, array $additionalData = [])
    {
        $query->orderBy('products.price', $this->direction);
    }
}
