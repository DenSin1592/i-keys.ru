<?php

namespace App\Services\DataProviders\ClientProduct\Plugins;

use App\Models\Product;
use App\Models\Service;
use App\Services\DataProviders\ClientProduct\ClientProductPlugin;
use App\Services\Product\Series\SorterSeries;
use App\Services\Repositories\Product\EloquentProductRepository;
use Illuminate\Database\Eloquent\Collection;


class Services implements ClientProductPlugin
{
    public function __construct(
        private EloquentProductRepository $repository,
        private SorterSeries $sorter
    ) {}


    public function getForProduct(Product $product): array
    {
        $services = $this->repository->getServicesForProduct($product);

        $services = $this->sorter->sortForProductPage($services);

        return ['services' => $services];
    }
}
