<?php

namespace App\Services\Catalog\Filter\Lens;

use App\Services\Catalog\Filter\LensFeatures\ArrayLens;


class OptionLens implements LensInterface
{
    use ArrayLens;

    private const ALL_PRODUCT = 'all_product';
    private const BEST_PRODUCT = 'best_product';
    private const DISCOUNT_PRODUCTS = 'discount_products';


    public function modifyQuery($query, $lensData)
    {
        if (!is_array($lensData) || count($lensData) === 0) {
            return $query;
        }

        if(in_array(self::BEST_PRODUCT, $lensData)){
            $query->where('products.best_prod', true);
        }

        if(in_array(self::DISCOUNT_PRODUCTS, $lensData)){
            $query->where('products.price', '<', 'products.old_price');
        }

        return $query;
    }


    public function getVariants($query, $restrictedQuery, $lensData)
    {

        $variants = [
            $this->getAllProductsVariant($restrictedQuery, $lensData),
            $this->getBestProductsVariant($restrictedQuery, $lensData),
            $this->getDiscountProductsVariant($restrictedQuery, $lensData),
        ];

        return $variants;
    }


    private function getAllProductsVariant($restrictedQuery, $lensData)
    {
        if (!is_array($lensData)) {
            $lensData = [];
        }

        $cheked = empty(array_intersect([self::BEST_PRODUCT, self::DISCOUNT_PRODUCTS], $lensData));;
        $count =  $restrictedQuery->select('products.*')->count();

        $variant = [
            'name' => 'Показать все',
            'value' => self::ALL_PRODUCT,
            'checked' => $cheked,
            'available' => true,
            'count' => $count,
        ];

        return $variant;
    }


    private function getBestProductsVariant($restrictedQuery, $lensData)
    {
        if (!is_array($lensData)) {
            $lensData = [];
        }

        $cheked = in_array(self::BEST_PRODUCT, $lensData);
        $count =  $restrictedQuery->where('products.best_prod', true)->select('products.*')->count();

        $variant = [
            'name' => 'Показать лучшие товары',
            'value' => self::BEST_PRODUCT,
            'checked' => $cheked,
            'available' => $count > 0 || $cheked,
            'count' => $count,
        ];

        return $variant;
    }


    private function getDiscountProductsVariant($restrictedQuery, $lensData)
    {
        if (!is_array($lensData)) {
            $lensData = [];
        }

        $cheked = in_array(self::DISCOUNT_PRODUCTS, $lensData);
        $count =  $restrictedQuery->where('products.price', '<', 'products.old_price')->select('products.*')->count();

        $variant = [
            'name' => 'Показать товары со скидками',
            'value' => self::DISCOUNT_PRODUCTS,
            'checked' => $cheked,
            'available' => $count > 0 || $cheked,
            'count' => $count,
        ];

        return $variant;
    }
}
