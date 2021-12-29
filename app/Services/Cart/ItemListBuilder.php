<?php

namespace App\Services\Cart;

use App\Services\Product\Series\SorterSeries;
use App\Services\Repositories\Product\EloquentProductRepository;


class ItemListBuilder
{
    public function __construct(
        private EloquentProductRepository $productRepository,
        private SorterSeries $sorterSeries
    ){}


    public function buildDataFor(): array
    {
        $itemListData = [];
        $itemList = \Cart::items();

        foreach ($itemList as $item) {
            $itemListData[] = $this->getItemData($item);
        }

        return [
            'items' => $itemListData,
        ];
    }


    private function getItemData(CartItem $item)
    {
        $product = $item->getProduct();
        $count = $item->getCount();

        $series = $this->productRepository->getServicesForProduct($product);
        $series = $this->sorterSeries->sortForCartItem($series);

        $finalProductPrice = $product->price * $count;

        return [
            'product' => $product,
            'count' => $count,
            'series' => $series,
            'finalProductPrice' => $finalProductPrice,
        ];
    }
}
