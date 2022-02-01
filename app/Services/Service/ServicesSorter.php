<?php

namespace App\Services\Service;

use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;


class ServicesSorter
{
    public function sortForProductPage(Collection $series): array
    {
        $sortedSubData = [];

        foreach ($series as $element){
            if($element->id === Service::ADD_KEYS_ID){
                $sortedSubData[Service::ADD_KEYS_ALIAS] = $element;
            }else{
                if(isset($sortedSubData['general']) && count($sortedSubData['general']) === 3){
                    continue;
                }
                $sortedSubData['general'][] = $element;
            }
        }

        return $sortedSubData;
    }


    public function sortForCartItem(Collection $series): array
    {
        $sortedSubData = [];

        foreach ($series as $element){
            if($element->id === Service::ADD_KEYS_ID){
                $sortedSubData['add_keys'] = $element;
            }else{
                $sortedSubData['general'][] = $element;
            }
        }

        return $sortedSubData;
    }

}
