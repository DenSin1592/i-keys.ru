<?php

namespace App\Services\UrlBuilder;

use App\Models\Category;
use App\Models\Node;
use App\Models\Product;
use App\Models\ProductTypePage;


class UrlBuilder
{
    public function getUrl(\Eloquent $model): string
    {
        if ($model instanceof Node) {
            return \TypeContainer::getClientUrl($model);
        }

        if ($model instanceof Category) {
            return route('category', implode('/', $model->getAliasPath()));
        }

        if ($model instanceof Product) {
            return route('product', [$model->id]);
        }

        if ($model instanceof ProductTypePage) {
            return route('product_types_page', implode('/', $model->getAliasPath()));
        }

        throw new \InvalidArgumentException('Incorrect url data');
    }


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


    public function buildTypeUrl(ProductTypePage $type): string
    {
        $typePath = [];
        foreach ($type->extractParentPath() as $parentType) {
            $typePath[] = $parentType;
        }
        $typePath[] = $type;

        $category = $typePath[count($typePath) - 1]->category;
        $categoryPath = [];
        foreach ($category->extractParentPath() as $parentCategory) {
            $categoryPath[] = $parentCategory;
        }
        $categoryPath[] = $category;

        $aliasPath = [];
        foreach (array_merge($categoryPath, $typePath) as $model) {
            $aliasPath[] = $model->alias;
        }

//        return $this->buildCategoryUrlFromAliasPath($aliasPath);
        return '#';
    }
}
