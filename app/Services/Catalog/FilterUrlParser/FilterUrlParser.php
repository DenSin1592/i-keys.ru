<?php namespace App\Services\Catalog\FilterUrlParser;

use App\Services\Catalog\FilterUrlParser\Exception\IncorrectCategory;
use App\Services\Repositories\Category\EloquentCategoryRepository;


/**
 * Class FilterUrlParser
 * Parser for filter url.
 *
 * @package App\Services\Catalog\FilterUrlParser
 */
class FilterUrlParser
{
    private $categoryRepository;

    /**
     * FilterUrlParser constructor.
     * @param EloquentCategoryRepository $categoryRepository
     */
    public function __construct(EloquentCategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Parse filter url.
     *
     * @param string $filterUrl
     * @return array ['category' => Category $category, 'filterData' => array, 'sort' => string|null] - contains category and filter data.
     * @throws IncorrectCategory
     */
    public function parseFilterUrl(string $filterUrl): array
    {
        $filterUrl = trim(trim($filterUrl), '/');
        $parsedUrl = parse_url($filterUrl);

        $path = \Arr::get($parsedUrl, 'path');
        if (!is_string($path)) {
            $path = '';
        }
        $query = \Arr::get($parsedUrl, 'query');
        if (!is_string($query)) {
            $query = '';
        }

        $expPath = explode('/', $path);
        $categoryAlias = array_pop($expPath);
        if (empty($categoryAlias)) {
            throw new IncorrectCategory("Category alias cannot be empty.");
        }

        parse_str($query, $queryData);
        $filterData = \Arr::get($queryData, 'filter', []);
        if (!is_array($filterData)) {
            $filterData = [];
        }

        $sort = \Arr::get($queryData, 'sort');
        if (!is_string($sort)) {
            $sort = null;
        }

        /** @var \App\Models\Category $category */
        $category = $this->categoryRepository->findCachedByAlias($categoryAlias);
        if ($category === null) {
            throw new IncorrectCategory("Category with alias {$categoryAlias} is not found");
        }

        return [
            'category' => $category,
            'filterData' => $filterData,
            'sort' => $sort,
        ];
    }
}
