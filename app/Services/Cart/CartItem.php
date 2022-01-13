<?php

namespace App\Services\Cart;

use App\Models\Service;


class CartItem
{
    private $product;
    private int $count;
    private array $services;

    public function __construct($product, $count, $services = [])
    {
        $this->product = $product;
        $this->setCount($count);
        $this->services = $services;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function getPrice()
    {
        return $this->product->price;
    }

    public function setCount($count)
    {
        $this->count = $count;
    }

    public function setService(Service $service, int $count)
    {
        if ($count === 0 && isset($this->services[$service->id])) {
            unset($this->services[$service->id]);
            return;
        }

        if($count === 0){
            return;
        }

        $this->services[$service->id] = new CartItemService($service, $count);
    }

    public function getServices()
    {
        return $this->services;
    }

    public function getServiceCount($id): int
    {
        if (isset($this->services[$id])) {
            return $this->services[$id]->getCount();
        }
        return 0;

    }

    public function checkService($serviceId)
    {
        return isset($this->services[$serviceId]);
    }
}
