<?php

namespace App\Services\DataProviders\ClientProduct\Plugins;

use App\Models\Product;
use App\Models\Service;
use App\Services\DataProviders\ClientProduct\ClientProductPlugin;
use App\Services\Repositories\Product\EloquentProductRepository;
use Illuminate\Database\Eloquent\Collection;


class Services implements ClientProductPlugin
{
    public function __construct(
        private EloquentProductRepository $repository
    ) {}


    public function getForProduct(Product $product): array
    {
        $services = $this->repository->getServicesForProduct($product);

        $services = $this->sortedSubData($services);

        return ['services' => $services];
    }


    private function sortedSubData(Collection $subData): array
    {
        $sortedSubData = [];

        foreach ($subData as $element){
            if($element->id === Service::ADD_KEYS_ID){
                $sortedSubData['add_keys'] = $element;
            }else{
                if(isset($sortedSubData['general']) && count($sortedSubData['general']) === 3){
                    continue;
                }
                $sortedSubData['general'][] = $element;
            }

        }

        return $sortedSubData;
    }
}
