<?php

namespace App\Services\DataProviders\ClientProduct\Plugins;

use App\Models\Product;
use App\Models\Service;
use App\Services\DataProviders\ClientProduct\ClientProductPlugin;
use App\Services\Service\ServicesSorter;
use App\Services\Repositories\Product\EloquentProductRepository;
use Illuminate\Database\Eloquent\Collection;


class Services implements ClientProductPlugin
{
    public function __construct(
        private EloquentProductRepository $repository,
        private ServicesSorter $servicesSorter
    ){}


    public function getForProduct(Product $product): array
    {
        $services = $this->repository->getServicesForProduct($product);
        $services = $this->servicesSorter->sortForProductPage($services);
        $this->setPriceToCopyKey($product, $services);

        return ['services' => $services];
    }

    private function setPriceToCopyKey(Product $product, array &$services): void
    {
        if(!isset($services[Service::ADD_KEYS_ALIAS])){
            return;
        }

        if(is_null($product->price_copy_key)){
            return;
        }

        $services[Service::ADD_KEYS_ALIAS]->price = $product->price_copy_key;
    }
}
