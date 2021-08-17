<?php namespace App\Services\Catalog;

/**
 * Class CatalogHelper
 * Helpers for catalog.
 *
 * @package App\Services\Catalog
 */
class CatalogHelper
{
    /**
     * Get url with sorting according to current request.
     *
     * @param array $currentFilterQuery
     * @param string $sorting
     * @return string
     */
    public function getSortingUrl(array $currentFilterQuery, string $sorting): string
    {
        $data = $currentFilterQuery;
        $data['sort'] = $sorting;

        return \Helper::urlWithHttpQuery(route('filter_proxy'), $data);
    }

    /**
     * Get url with sorting according to current request.
     *
     * @param array $currentFilterQuery
     * @return string
     */
    public function getFilterResetUrl(array $currentFilterQuery): string
    {
        $data = $currentFilterQuery;
        \Arr::forget($data, 'filter');
        \Arr::forget($data, 'additional');

        return \Helper::urlWithHttpQuery(route('filter_proxy'), $data);
    }

    public function getDropSelectedVariantUrl(array $currentFilterQuery, array $variantData): string
    {
        $data = $currentFilterQuery;
        foreach ($variantData as $key => $value) {
            $selectedData = \Arr::get($data, $key);
            if (!is_null($selectedData)) {
                if (is_array($selectedData)) {
                    $valueKey = array_search($value, $selectedData);
                    if ($valueKey !== false) {
                        unset($selectedData[$valueKey]);
                        \Arr::set($data, $key, $selectedData);
                    }
                } else {
                    \Arr::forget($data, $key);
                }
            }
        }

        return \Helper::urlWithHttpQuery(route('filter_proxy'), $data);
    }
}
