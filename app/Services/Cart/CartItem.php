<?php

namespace App\Services\Cart;


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

    public function setService(int $serviceId, int $count)
    {
        if($count === 0 && isset($this->services[$serviceId])){
            unset($this->services[$serviceId]);
        } else {
            $this->services[$serviceId] = $count;
        }
    }

    public function getServices()
    {
        return $this->services;
    }
}
