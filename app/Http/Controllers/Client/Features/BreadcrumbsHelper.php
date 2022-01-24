<?php

namespace App\Http\Controllers\Client\Features;

use App\Models\Node;
use App\Services\Breadcrumbs\Factory as Breadcrumbs;


trait BreadcrumbsHelper
{
    protected function getBreadcrumbsForNode(Breadcrumbs $breadcrumbsFactory, Node $node)
    {
        $treePath = $node->extractPath();
        $breadcrumbs = $breadcrumbsFactory->initFromCollection(
            $treePath,
            function (Node $node) {
                return [$node->name, \TypeContainer::getClientUrl($node)];
            }
        );

        return $breadcrumbs;
    }
}
