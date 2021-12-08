<?php

namespace App\Services\DataProviders\ProductListPage;

use App\Models\Category;
use App\Providers\CatalogServiceProvider;
use App\Services\Repositories\Product\EloquentProductRepository;
use JetBrains\PhpStorm\ArrayShape;


class FilterVariantsProvider
{
    public function __construct(
        protected EloquentProductRepository $productRepository
    ){}

    #[ArrayShape(['filterVariants' => "array", 'sortingVariants' => "array", 'isSelectedFilterVariants' => "bool", 'currentFilterQuery' => "array", 'filterOpen' => "bool"])]
    public function getFilterVariants(Category $category, array $filterData, string $sortInput, string $productsView): array
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

        $isSelectedFilterVariants = $this->isSelectedFilterVariants($filterData, $filterVariants);

        return [
            'filterVariants' => $filterVariants,
            'sortingVariants' => $sortingVariants,
            'isSelectedFilterVariants' => $isSelectedFilterVariants,
            'currentFilterQuery' => $currentFilterQuery,
            'filterOpen' => count($filterData) > 0,
        ];
    }

    private function prepareFilterVariants(array $filterVariants)
    {
        foreach ($filterVariants as &$filterVariant) {

            if (in_array($filterVariant['view'], CatalogServiceProvider::MULTIPLE_VIEWS_FOR_SELECTED_BLOCK)) {
                $firstChecked = \Arr::first($filterVariant['variants'], static fn($value) => $value['checked']);
                $filterVariant['optional']['checked'] = !is_null($firstChecked);
                continue;
            }

            if ($filterVariant['view'] === 'range') {
                $filterVariant['optional']['checked'] =
                    $filterVariant['variants']['min'] < $filterVariant['variants']['from']
                    || $filterVariant['variants']['max'] > $filterVariant['variants']['to'];
                continue;
            }

            if ($filterVariant['view'] === 'cylinder_size') {
                $firstChecked = \Arr::first($filterVariant['variants']['first_size'], static fn($value) => $value['checked']);
                if ($firstChecked) {
                    $filterVariant['optional']['checked'] = true;
                    continue;
                }
                $secondChecked = \Arr::first($filterVariant['variants']['second_size'], static fn($value) => $value['checked']);
                if ($secondChecked) {
                    $filterVariant['optional']['checked'] = true;
                    continue;
                }
            }

            $filterVariant['optional']['checked'] = false;
        }

        return $filterVariants;
    }

    private function isSelectedFilterVariants(array $filterData, array $filterVariants): bool
    {
        unset($filterData['options']);

        if (count($filterVariants) === 0 || count($filterData) === 0) {
            return false;
        }

        foreach ($filterVariants as $lensData) {
            if (!isset($filterData[$lensData['key']])) {
                continue;
            }

            if (in_array($lensData['view'], CatalogServiceProvider::MULTIPLE_VIEWS_FOR_SELECTED_BLOCK)) {
                $selectedVariants = $this->getMultipleCheckboxesSelectedVariants(
                    $filterData,
                    $lensData,
                );
                if ($selectedVariants) {
                    return true;
                }
            }

            if ($lensData['view'] === 'range') {
                $selectedVariants = $this->getRangeSelectedVariants(
                    $filterData,
                    $lensData,
                );

                if ($selectedVariants) {
                    return true;
                }
            }

            if ($lensData['view'] === 'cylinder_size') {
                $selectedVariants = $this->getCylinderSizeSelectedVariants(
                    $filterData,
                    $lensData,
                );
                if ($selectedVariants) {
                    return true;
                }
            }
        }

        return false;
    }

    private function getMultipleCheckboxesSelectedVariants(
        array $filterData,
        $lensData,
    ): bool
    {
        if (is_array($filterData[$lensData['key']])) {
            foreach ($lensData['variants'] as $variant) {
                if (in_array($variant['value'], $filterData[$lensData['key']])) {
                    return true;
                }
            }
        }

        return false;
    }

    private function getRangeSelectedVariants(
        array $filterData,
        $lensData,
    ): bool
    {
        return !(!is_array($filterData[$lensData['key']])
            || !$lensData['optional']['checked']);
    }


    private function getCylinderSizeSelectedVariants(
        array $filterData,
        $lensData,

    ): bool
    {
        if (is_array($filterData[$lensData['key']])) {
            foreach ($lensData['variants']['first_size'] as $variant) {

                if (isset($filterData[$lensData['key']][0]) && in_array($variant['value'], [$filterData[$lensData['key']][0]])) {
                    return true;
                }
            }

            foreach ($lensData['variants']['second_size'] as $variant) {
                if (isset($filterData[$lensData['key']][1]) && in_array($variant['value'], [$filterData[$lensData['key']][1]])) {
                    return true;
                }
            }
        }

        return false;
    }
}

