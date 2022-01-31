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
            $query->whereColumn('products.price', '<', 'products.old_price');
        }

        return $query;
    }


    public function getVariants($query, $restrictedQuery, $lensData)
    {
        $variants = [
            $this->getAllProductsVariant(clone $restrictedQuery, $lensData),
            $this->getBestProductsVariant(clone $restrictedQuery, $lensData),
            $this->getDiscountProductsVariant(clone $restrictedQuery, $lensData),
        ];

        $result = [];

        foreach ($variants as $array){
            if(count($array)){
                $result[] = $array;
            }
        }

        return $result;
    }


    private function getAllProductsVariant($restrictedQuery, $lensData)
    {
        if (!is_array($lensData)) {
            $lensData = [];
        }

        $checked = empty(array_intersect([self::BEST_PRODUCT, self::DISCOUNT_PRODUCTS], $lensData));
        $count =  $restrictedQuery->select('products.*')->distinct()->get()->count();

        $variant = [
            'name' => 'Показать все',
            'value' => self::ALL_PRODUCT,
            'checked' => $checked,
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

        $checked = in_array(self::BEST_PRODUCT, $lensData);
        $count =  $restrictedQuery->where('products.best_prod', true)->select('products.*')->distinct()->get()->count();

        if ($count === 0){
            return [];
        }

        $variant = [
            'name' => 'Показать лучшие товары',
            'value' => self::BEST_PRODUCT,
            'checked' => $checked,
            'available' => $count > 0 || $checked,
            'count' => $count,
        ];

        return $variant;
    }


    private function getDiscountProductsVariant($restrictedQuery, $lensData)
    {
        if (!is_array($lensData)) {
            $lensData = [];
        }

        $checked = in_array(self::DISCOUNT_PRODUCTS, $lensData);
        $count =  $restrictedQuery->whereColumn('products.price', '<', 'products.old_price')->select('products.*')->distinct()->get()->count();

        if ($count === 0){
            return [];
        }

        $variant = [
            'name' => 'Показать товары со скидками',
            'value' => self::DISCOUNT_PRODUCTS,
            'checked' => $checked,
            'available' => $count > 0 || $checked,
            'count' => $count,
        ];

        return $variant;
    }
}
