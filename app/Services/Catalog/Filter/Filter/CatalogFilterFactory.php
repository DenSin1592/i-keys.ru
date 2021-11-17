<?php

namespace App\Services\Catalog\Filter\Filter;

use App\Models\Category;


class CatalogFilterFactory
{
    private array $filterList = [];


    public function __construct(
        private  FilterLensAggregator $defaultFilter
    ) {}


    public function addFilter($filterType, FilterInterface $filter): void
    {
        $this->filterList[$filterType] = $filter;
    }


    private function getFilter(string $filterType): FilterInterface
    {
        return $this->filterList[$filterType] ?? $this->defaultFilter;
    }


    public function getFilterByCategory(Category $category): FilterInterface
    {
        return $this->getFilter($category->code_1c ?? '');
    }
}
