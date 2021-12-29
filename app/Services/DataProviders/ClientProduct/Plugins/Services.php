<?php

namespace App\Services\DataProviders\ClientProduct\Plugins;

use App\Models\Product;
use App\Services\DataProviders\ClientProduct\ClientProductPlugin;
use App\Services\Product\Attribute\Series\SeriesSorter;
use App\Services\Repositories\Product\EloquentProductRepository;


class Services implements ClientProductPlugin
{
    public function __construct(
        private EloquentProductRepository $repository,
        private SeriesSorter $seriesSorter
    ){}


    public function getForProduct(Product $product): array
    {
        $services = $this->repository->getServicesForProduct($product);

        $services = $this->seriesSorter->sortForProductPage($services);

        return ['services' => $services];
    }
}
