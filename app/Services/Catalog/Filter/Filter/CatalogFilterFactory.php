<?php namespace App\Services\Catalog\Filter\Filter;

use App\Models\Category;
use App\Services\Repositories\Category\EloquentCategoryRepository;


/**
 * Class CatalogFilterFactory
 * @package App\Services\Catalog\Filter\Filter
 */
class CatalogFilterFactory
{
    /** @var EloquentCategoryRepository */
    private $categoryRepository;

    /**
     * @var FilterInterface
     */
    private $defaultFilter;
    /**
     * @var FilterInterface[]
     */
    private $filterList = [];


    public function __construct(
        EloquentCategoryRepository $categoryRepository,
        FilterInterface $defaultFilter
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->defaultFilter = $defaultFilter;
    }

    /**
     * Add filter to list.
     *
     * @param $filterType
     * @param FilterInterface $filter
     */
    public function addFilter($filterType, FilterInterface $filter)
    {
        $this->filterList[$filterType] = $filter;
    }

    /**
     * Get filter for category by $filterType (code_1c). Default filter can be returned.
     *
     * @param $filterType
     * @return FilterInterface
     */
    private function getFilter(string $filterType): FilterInterface
    {
        if (isset($this->filterList[$filterType])) {
            return $this->filterList[$filterType];
        } else {
            return $this->defaultFilter;
        }
    }

    /**
     * Get filter for category. Default filter can be returned.
     *
     * @param Category|null $category
     * @return FilterInterface
     */
    public function getFilterByCategory(Category $category)
    {
        return $this->getFilter($category->code_1c ?? '');
    }
}
