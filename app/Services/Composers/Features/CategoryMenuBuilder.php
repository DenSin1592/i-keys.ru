<?php

namespace App\Services\Composers\Features;


trait CategoryMenuBuilder
{

    private function buildMenu($elemList): array
    {
        $menu = [];
        foreach ($elemList as $elem) {
            $url = \UrlBuilder::buildCategoryUrl($elem);
            $menu[] = [
                'name' => $elem->name,
                'url' => $url,
                'active' => \StringHelper::checkUrlIncludes(\URL::current(), $url),
                'image_path' =>$elem->path_to_icon,
            ];
        }
        return $menu;
    }
}

