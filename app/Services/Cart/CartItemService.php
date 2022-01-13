<?php

namespace App\Services\Cart;


class CartItemService
{
    private $service;
    private int $count;

    public function __construct($service, $count)
    {
        $this->service = $service;
        $this->setCount($count);
    }

    public function getService()
    {
        return $this->service;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function getPrice()
    {
        return $this->service->price;
    }

    public function setCount($count)
    {
        $this->count = $count;
    }
}
