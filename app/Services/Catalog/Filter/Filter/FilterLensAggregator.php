<?php namespace App\Services\Catalog\Filter\Filter;

use App\Providers\CatalogServiceProvider;

/**
 * Class FilterLensAggregator
 * Filter which aggregates lenses.
 *
 * @package App\Services\Catalog\Filter\Filter
 */
class FilterLensAggregator implements FilterInterface
{
    /**
     * @var FilterLensWrapper[]
     */
    private $lensWrapperList = [];

    /**
     * Add lens to filter.
     *
     * @param FilterLensWrapper $lensWrapper
     */
    public function addLens(FilterLensWrapper $lensWrapper)
    {
        $this->lensWrapperList[] = $lensWrapper;
    }

    /**
     * @inheritdoc
     */
    public function getVariants($query, array $filterData)
    {
        $variants = [];
        foreach ($this->lensWrapperList as $key => $lensWrapper) {
            $lensKey = $lensWrapper->getKey();
            $lensData = $this->getLensData($filterData, $lensWrapper);
            $restrictedFilterData = $filterData;
            if (isset($restrictedFilterData[$lensKey])) {
                unset($restrictedFilterData[$lensKey]);
            }
            $restrictedQuery = $this->modifyQuery(clone $query, $restrictedFilterData);
            $lensVariants = $lensWrapper->getLens()->getVariants(clone $query, $restrictedQuery, $lensData);

            if (!is_null($lensVariants)) {
                $variants[] = [
                    'name' => $lensWrapper->getName(),
                    'key' => $lensWrapper->getKey(),
                    'variants' => $lensVariants,
                    'view' => $lensWrapper->getView(),
                    'optional' => $lensWrapper->getOptional(),
                ];
            }
        }

        return $variants;
    }

    /**
     * @inheritdoc
     */
    public function modifyQuery($query, array $filterData)
    {
        $baseQuery = clone $query;

        foreach ($this->lensWrapperList as $lensWrapper) {
            $lens = $lensWrapper->getLens();
            $lensData = $this->getLensData($filterData, $lensWrapper);
            $cleanLensData = $lens->cleanLensData(clone $baseQuery, $lensData);
            if (!is_null($cleanLensData)) {
                $lensWrapper->getLens()->modifyQuery($query, $lensData);
            }
        }

        return $query;
    }


    /**
     * @inheritdoc
     */
    public function clearFilterData($query, array $filterData)
    {
        $cleanFilterData = [];

        foreach ($this->lensWrapperList as $lensWrapper) {
            $lens = $lensWrapper->getLens();
            $lensData = $this->getLensData($filterData, $lensWrapper);
            $cleanLensData = $lens->cleanLensData(clone $query, $lensData);
            if (!is_null($cleanLensData)) {
                $cleanFilterData[$lensWrapper->getKey()] = $cleanLensData;
            }
        }

        return $cleanFilterData;
    }


    /**
     * Get data for lens from filter data.
     *
     * @param array $filterData
     * @param FilterLensWrapper $lensWrapper
     * @return mixed
     */
    private function getLensData(array $filterData, FilterLensWrapper $lensWrapper)
    {
        $lensData = \Arr::get($filterData, $lensWrapper->getKey());

        if( is_array($lensData) && $lensWrapper->getKey() === CatalogServiceProvider::CYLINDER_SIZE_KEY ){
            if((empty($lensData[0]) && empty($lensData[1]))){
                $lensData = null;
            }
        }

        return $lensData;
    }

    /**
     * @inheritdoc
     */
    public function compareFilterData($query, array $baseFilterData, array $filterData)
    {
        foreach ($this->lensWrapperList as $lensWrapper) {
            $lens = $lensWrapper->getLens();

            $lensDataAlpha = $this->getLensData($filterData, $lensWrapper);
            $lensDataAlpha = $lens->cleanLensData(clone $query, $lensDataAlpha);

            $lensDataOmega = $this->getLensData($baseFilterData, $lensWrapper);
            if ((!is_null($lensDataAlpha) || !is_null($lensDataOmega))
                && $lens->compareLensData($lensDataAlpha, $lensDataOmega) === false
            ) {
                return false;
            }
        }

        return true;
    }
}
