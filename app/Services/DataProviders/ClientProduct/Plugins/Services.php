<?php

namespace App\Services\DataProviders\ClientProduct\Plugins;

use App\Models\Product;
use App\Services\DataProviders\ClientProduct\ClientProductPlugin;
use App\Services\Service\ServicesSorter;
use App\Services\Repositories\Product\EloquentProductRepository;


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

        return ['services' => $services];
    }
}
