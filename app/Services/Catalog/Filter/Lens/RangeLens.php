<?php

namespace App\Services\Catalog\Filter\Lens;


/**
 * Class RangeLens
 * Abstract filter to filter by range of integer values.
 *
 * @package App\Services\Repositories\StockRoom\Filter\Lens
 */
abstract class RangeLens implements LensInterface
{

    protected function extractRange($lensData)
    {
        $from = null;
        $to = null;
        if (is_array($lensData)) {
            $from = $lensData['from'] ?? null;
            $to = $lensData['to'] ?? null;
        }

        return array_map(function ($value) {
            return is_scalar($value) ? $value : null;
        }, [$from, $to]);
    }


    public function getVariants($query, $restrictedQuery, $lensData)
    {
        $this->commonQueryCond($restrictedQuery);
        $min = $this->getMin(clone $restrictedQuery);
        $max = $this->getMax(clone $restrictedQuery);

        $min = !is_null($min) ? floor($min) : 0;
        $max = !is_null($max) ? ceil($max) : 0;

        $fromValue = \Arr::get($lensData, 'from', $min);
        if (!is_scalar($fromValue)) {
            $fromValue = $min;
        } else {
            $fromValue = floor($fromValue);
        }

        $toValue = \Arr::get($lensData, 'to', $max);
        if (!is_scalar($toValue)) {
            $toValue = $max;
        } else {
            $toValue = ceil($toValue);
        }

        if ($min === $max) {
            return ['min' => $fromValue -10, 'max' => $toValue +10, 'from' => $fromValue, 'to' => $toValue, 'units' => $this->getUnits(), 'disabled' => true];
        }
        return ['min' => $min, 'max' => $max, 'from' => $fromValue, 'to' => $toValue, 'units' => $this->getUnits(), 'disabled' => false];

    }

    /**
     * Get min value for range.
     *
     * @param $query
     * @return mixed
     */
    abstract protected function getMin($query);


    /**
     * Get max value for range.
     *
     * @param $query
     * @return mixed
     */
    abstract protected function getMax($query);


    /**
     * Modify query to apply "from" condition.
     *
     * @param $query
     * @param $from
     * @return mixed
     */
    abstract protected function modifyQueryFrom($query, $from);


    /**
     * Modify query to apply "to" condition.
     *
     * @param $query
     * @param $to
     * @return mixed
     */
    abstract protected function modifyQueryTo($query, $to);


    /**
     * Add common query cond.
     *
     * @param $query
     * @return mixed
     */
    abstract protected function commonQueryCond($query);

    /**
     *
     * @return mixed
     */
    abstract protected function getUnits();
}
