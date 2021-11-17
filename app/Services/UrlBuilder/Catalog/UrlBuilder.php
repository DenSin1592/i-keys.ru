<?php

namespace App\Services\UrlBuilder\Catalog;

use App\Models\Category;


class UrlBuilder
{
    public function buildCategoryUrl(Category $category): string
    {
        $aliasPath = [];
        foreach ($category->extractParentPath() as $parentCategory) {
            $aliasPath[] = $parentCategory->alias;
        }
        $aliasPath[] = $category->alias;

        return $this->buildCategoryUrlFromAliasPath($aliasPath);
    }


    private function buildCategoryUrlFromAliasPath(array $aliasPath): string
    {
        $aliasPathStr = implode('/', $aliasPath);
        return route('category', $aliasPathStr);
    }
}
