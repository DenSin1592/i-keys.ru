<?php

namespace App\Services\Composers\Features;

use Illuminate\Database\Eloquent\Collection;


trait NodeMenuBuilder
{

    protected function buildMenu(Collection $nodeList): array
    {
        $menu = [];
        foreach ($nodeList as $node) {
            $nodeUrl = \TypeContainer::getClientUrl($node);
            $menu[] = [
                'name' => $node->name,
                'url' => $nodeUrl,
                'active' => \StringHelper::checkCurrentUrlIncludes($nodeUrl),
            ];
        }

        return $menu;
    }
}
