<?php namespace App\Services\Catalog\Filter\Lens;

/**
 * Class PriceLens
 * Lens to filter by price (range).
 *
 * @package App\Services\Catalog\Filter\Lens
 */
class PriceLens extends RangeLens
{
    protected function getMin($query)
    {
        return $query->selectRaw('MIN(CEIL(products.price)) AS min')->value('min');
    }

    protected function getMax($query)
    {
        return $query->selectRaw('MAX(CEIL(products.price)) AS max')->value('max');
    }

    protected function modifyQueryFrom($query, $from)
    {
        $query->whereRaw('CEIL(products.price) >= ' . (float)$from);
    }

    protected function modifyQueryTo($query, $to)
    {
        $query->whereRaw('CEIL(products.price) <= ' . (float)$to);
    }

    protected function commonQueryCond($query)
    {
        $query->where('products.price', '>', 0)
            ->whereNotNull('products.price');
    }

    protected function getUnits()
    {
        return 'руб.';
    }

    public function cleanLensData($query, $lensData)
    {
        return $lensData;
    }

    public function compareLensData($lensDataAlpha, $lensDataOmega)
    {
        if (is_array($lensDataAlpha) && is_array($lensDataOmega)) {
            sort($lensDataAlpha);
            sort($lensDataOmega);
            if ($lensDataAlpha == $lensDataOmega) {
                return true;
            }
        }

        return false;
    }
}
