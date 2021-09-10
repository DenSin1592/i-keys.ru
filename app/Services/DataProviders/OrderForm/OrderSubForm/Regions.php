<?php namespace App\Services\DataProviders\OrderForm\OrderSubForm;

use App\Models\Order;
use App\Services\DataProviders\OrderForm\OrderSubForm;
use App\Services\Repositories\Region\EloquentRegionRepository;

/**
 * Class Regions
 * @package App\Services\DataProviders\OrderForm\OrderSubForm
 */
class Regions implements OrderSubForm
{
    private $regionRepository;

    public function __construct(EloquentRegionRepository $regionRepository)
    {
        $this->regionRepository = $regionRepository;
    }

    public function provideDataFor(Order $order, array $oldData)
    {
        return ['region_variants' => $this->regionRepository->getVariants()];
    }
}
