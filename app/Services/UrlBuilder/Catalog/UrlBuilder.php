<?php

namespace App\Services\UrlBuilder\Catalog;

use App\Models\Category;
use App\Models\Node;
use App\Models\Product;
use App\Models\ProductTypePage;

class UrlBuilder
{
    /**
     * Build url for category.
     *
     * @param \App\Models\Category $category
     * @param array $humanFilterData
     * @param string $sorting
     * @param string $additional
     * @return string
     */
    public function buildCategoryUrl(Category $category, array $humanFilterData = [], string $sorting = '', string $additional = ''): string
    {
        return '';
    }

    public function getUrl(\Eloquent $model)
    {
        return '';
    }
}
