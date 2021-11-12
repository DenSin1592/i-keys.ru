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

        return $this->buildCatalogUrlFromAliasPath($aliasPath);
    }


    private function buildCatalogUrlFromAliasPath(array $aliasPath): string
    {
        $aliasPathStr = implode('/', $aliasPath);
        return route('catalog', $aliasPathStr);
    }
}
