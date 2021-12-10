<?php

namespace App\Services\Composers;

use App\Facades\Cart;


class ClientHeaderCartComposer
{

    public function compose($view)
    {
        $view->with('cartItemCount', Cart::summaryCount());
    }
}
