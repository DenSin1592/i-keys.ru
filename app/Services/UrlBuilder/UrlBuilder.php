<?php

namespace App\Services\UrlBuilder;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductTypePage;


class UrlBuilder
{
    public function getUrl(\Eloquent $model): string
    {
//        if ($model instanceof Node) {
//            return \TypeContainer::getClientUrl($model);
//        }

        if ($model instanceof Category) {
            return $this->buildUrlFromAliasPath($model->getAliasPath());
        }

        if ($model instanceof Product) {
            return $this->buildProductUrl($model);
        }

        if ($model instanceof ProductTypePage) {
            return route('product_types_page', implode('/', $model->getAliasPath()));
        }

        throw new \InvalidArgumentException('Incorrect url data');
    }


    private function buildProductUrl(Product $product): string
    {
        $aliasPath = [];
        foreach ($product->category->extractParentPath() as $category) {
            $aliasPath[] = $category->alias;
        }
        $aliasPath[] = $product->category->alias;
        $aliasPath[] = $product->alias;

        return $this->buildUrlFromAliasPath($aliasPath);
    }


    private function buildUrlFromAliasPath(array $aliasPath): string
    {
        $aliasPathStr = implode('/', $aliasPath);
        return route('catalog', $aliasPathStr);
    }
}
