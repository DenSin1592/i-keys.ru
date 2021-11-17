<?php

namespace App\Services\UrlBuilder;

use App\Models\Category;
use App\Models\Node;
use App\Models\Product;
use App\Models\ProductTypePage;

/**
 * Class UrlBuilder
 * @package App\Services\UrlBuilder
 */
class UrlBuilder
{
    public function getUrl(\Eloquent $model)
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
}
