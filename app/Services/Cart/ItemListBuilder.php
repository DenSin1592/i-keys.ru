<?php

namespace App\Services\Cart;

use App\Services\Product\Attribute\Color\ColorProvider;
use App\Services\Product\Attribute\Series\SeriesSorter;
use App\Services\Repositories\Product\EloquentProductRepository;


class ItemListBuilder
{
    public function __construct(
        private EloquentProductRepository $productRepository,
        private SeriesSorter $seriesSorter,
        private ColorProvider $colorProvider,
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
        $color = $this->colorProvider->getColorFromCartItem($product);

        $series = $this->productRepository->getServicesForProduct($product);
        $series = $this->seriesSorter->sortForCartItem($series);

        $finalProductPrice = $product->price * $count;

        return [
            'product' => $product,
            'count' => $count,
            'color' => $color,
            'series' => $series,
            'finalProductPrice' => $finalProductPrice,
        ];
    }
}
