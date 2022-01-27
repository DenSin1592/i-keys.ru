<?php

namespace App\Services\Composers\Features;


use App\Models\Category;

trait CategoryMenuBuilder
{
    private function buildMenu($elemList): array
    {


        $menu = [];
        foreach ($elemList as $elem) {
            $url = $elem->id === Category::COPIES_KEYS_ID
                ? route('service.show', \App\Models\Service::ADD_KEYS_ALIAS)
                : \UrlBuilder::getUrl($elem);
            $menu[] = [
                'name' => $elem->name,
                'url' => $url,
                'active' => \StringHelper::checkUrlIncludes(\URL::current(), $url),
                'image_path' => $elem->path_to_icon,
                'megamenu' => $elem->content_for_submenu,

            ];
        }
        return $menu;
    }
}

