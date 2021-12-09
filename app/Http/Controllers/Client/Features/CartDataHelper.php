<?php

namespace App\Http\Controllers\Client\Features;

trait CartDataHelper
{
    protected function getWidgetCartContent()
    {
        return \View::make('client.layouts._widgets._cart')->render();
    }

    protected function getTopCartContent()
    {
        return \View::make('client.layouts._header._top_cart')->render();
    }

    protected function getCartTotalPriceFormatted(): string
    {
        return \Helper::priceFormat(\Cart::totalPrice());
    }

    protected function getCartEmptyContent()
    {
        return \View::make('client.cart_page._empty')->render();
    }

    protected function getCartItemsContent()
    {
        return \View::make('client.cart_page._cart_items')->render();
    }
}