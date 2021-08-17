<?php

namespace App\Services\FormProcessors\Product\SubProcessor;

use App\Models\Product;
use App\Services\FormProcessors\Product\SubProcessor;

class RelatedProducts implements SubProcessor
{
    /**
     * @inheritDoc
     */
    public function prepareInputData(array $data): array
    {
        return $data;
    }

    /**
     * @inheritDoc
     */
    public function save(Product $product, array $data)
    {
        $relatedProductsData = \Arr::get($data, 'related_products', []);
        if (!is_array($relatedProductsData)) {
            return;
        }

        $relatedProductIds = [];
        foreach ($relatedProductsData as $relatedProductData) {
            $relatedProductIds[] = $relatedProductData['product_id'];
        }

        $changes = $product->relatedProducts()->sync($relatedProductIds);
        $changed = false;
        foreach ($changes as $changedIds) {
            if (count($changedIds) > 0) {
                $changed = true;
                break;
            }
        }
        if ($changed) {
            $product->touch();
        }
    }

}