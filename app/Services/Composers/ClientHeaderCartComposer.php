<?php

namespace App\Services\Composers;

use App\Services\Cart\Cart;

class ClientHeaderCartComposer
{
    public function __construct(
        private Cart $cart
    ){}

    public function compose($view)
    {
        $view->with('cartItemCount', $this->cart->totalCount());
    }
}
