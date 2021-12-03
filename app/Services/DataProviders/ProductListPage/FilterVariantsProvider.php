<?php

namespace App\Services\DataProviders\ProductListPage;

use App\Models\Category;
use App\Providers\CatalogServiceProvider;
use App\Services\Repositories\Product\EloquentProductRepository;


class FilterVariantsProvider
{
    protected $productRepository;

    public function __construct(EloquentProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getFilterVariants(Category $category, array $filterData, $sortInput, $productsView)
    {
        $filterVariants = $this->productRepository->filterVariants($category, $filterData);
        $filterVariants = $this->prepareFilterVariants($filterVariants);
        $sortingVariants = $this->productRepository->getSortingVariants($sortInput);

        $currentFilterQuery = [
            'filter' => $filterData,
            'sort' => $sortInput,
            'category' => $category->id,
            'view' => $productsView,
        ];

        $selectedFilterVariants = $this->getSelectedFilterVariants($filterData, $filterVariants, $currentFilterQuery);

        return [
            'filterVariants' => $filterVariants,
            'sortingVariants' => $sortingVariants,
            'selectedFilterVariants' => $selectedFilterVariants,
            'currentFilterQuery' => $currentFilterQuery,
            'filterOpen' => count($filterData) > 0,
        ];
    }

    private function prepareFilterVariants(array $filterVariants)
    {
        foreach ($filterVariants as &$filterVariant) {
            if (in_array($filterVariant['view'], CatalogServiceProvider::MULTIPLE_VIEWS_FOR_SELECTED_BLOCK)) {
                $firstChecked = \Arr::first($filterVariant['variants'], function($value, $key) {
                    return $value['checked'];
                });
                $checked = !is_null($firstChecked) ? true: false;
            } elseif($filterVariant['view'] === 'range') {
                $checked = $filterVariant['variants']['min'] < $filterVariant['variants']['from'] ||
                    $filterVariant['variants']['max'] > $filterVariant['variants']['to'];
            } else {
                $checked = false;
            }

            $filterVariant['optional']['checked'] = $checked;
        }

        return $filterVariants;
    }

    private function getSelectedFilterVariants(array $filterData, array $filterVariants, array $currentFilterQuery)
    {
        $selectedVariants = [];
        if (count($filterVariants) > 0 && count($filterData) > 0) {
            foreach ($filterVariants as $lensData) {
                if (!isset($filterData[$lensData['key']])) {
                    continue;
                }

                if (in_array($lensData['view'],CatalogServiceProvider::MULTIPLE_VIEWS_FOR_SELECTED_BLOCK)) {
                    $selectedVariants = $this->getMultipleCheckboxesSelectedVariants(
                        $filterData,
                        $lensData,
                        $selectedVariants,
                        $currentFilterQuery
                    );
                } elseif ($lensData['view'] == 'range') {
                    $selectedVariants = $this->getRangeSelectedVariants(
                        $filterData,
                        $lensData,
                        $selectedVariants,
                        $currentFilterQuery
                    );
                }
            }
        }

        foreach ($selectedVariants as &$variant) {
            $variant['name'] = \Str::ucfirst($variant['name']);
        }

        return $selectedVariants;
    }

    private function getMultipleCheckboxesSelectedVariants(
        array $filterData,
        $lensData,
        array $selectedVariants,
        array $currentFilterQuery
    ) {
        if (is_array($filterData[$lensData['key']])) {
            foreach ($lensData['variants'] as $variant) {
                if (in_array($variant['value'], $filterData[$lensData['key']])) {
                    $selectedVariants[] = [
                        'name' => $lensData['name'] . ": " . $variant['name'],
                        'link' => \CatalogHelper::getDropSelectedVariantUrl(
                            $currentFilterQuery,
                            ["filter.{$lensData['key']}" => $variant['value']]
                        ),
                    ];
                }
            }
        }

        return $selectedVariants;
    }

    private function getRangeSelectedVariants(
        array $filterData,
        $lensData,
        array $selectedVariants,
        array $currentFilterQuery
    ): array
    {
        if( !is_array($filterData[$lensData['key']])
            || !$lensData['optional']['checked']){
            return $selectedVariants;
        }


            $name = $lensData['name'] . ':';
            $valueData = [];
            foreach ($filterData[$lensData['key']] as $rangeKey => $variant) {
                if (in_array($rangeKey, ['from', 'to'])) {
                    if ($rangeKey == 'from') {
                        $name .= ' от ' . \Str::formatDecimal($variant, '.', '', false);
                    } elseif ($rangeKey == 'to') {
                        $name .= ' до ' . \Str::formatDecimal($variant, '.', '', false);
                    }
                    $valueData["filter.{$lensData['key']}.{$rangeKey}"] = $variant;
                }

            }
            if (count($valueData) > 0) {
                $selectedVariants[] = [
                    'name' => $name,
                    'link' => \CatalogHelper::getDropSelectedVariantUrl($currentFilterQuery, $valueData),
                ];
            }


        return $selectedVariants;
    }
}
