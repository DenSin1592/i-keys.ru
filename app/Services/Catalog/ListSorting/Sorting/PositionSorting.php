<?php namespace App\Services\Catalog\ListSorting\Sorting;

use App\Models\ProductTypePage;
use App\Services\Catalog\ListSorting\Sorting;

class PositionSorting extends Sorting
{
    public function modifyQuery($query, array $additionalData = [])
    {
        $productTypePage = \Arr::get($additionalData, 'productTypePage');
        if (isset($productTypePage) && $productTypePage instanceof ProductTypePage) {
            $query->leftJoin(
                'product_type_page_associations',
                function ($join) use ($productTypePage) {
                    $join->on('product_type_page_associations.product_id', '=', 'products.id')
                        ->where('product_type_page_associations.product_type_page_id', '=', $productTypePage->id);
                }
            );
            $query->orderByRaw(
                "ISNULL(product_type_page_associations.position) {$this->direction}"
            );
            $query->orderBy('product_type_page_associations.position', $this->direction);
        }

        $query->orderBy('products.position', $this->direction);
    }
}
