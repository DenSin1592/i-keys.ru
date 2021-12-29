<?php

namespace App\Services\Cart;


class CartItem
{
    private $product;
    private int $count;

    public function __construct($product, $count)
    {
        $this->product = $product;
        $this->setCount($count);
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
}
