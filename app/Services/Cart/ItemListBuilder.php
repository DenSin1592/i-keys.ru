<?php

namespace App\Services\Cart;

use App\Models\Service;
use App\Services\Product\Attribute\Color\DataProvider;
use App\Services\Product\Attribute\CountKeysInSet\CountKeysInSetProvider;
use App\Services\Repositories\Product\EloquentProductRepository;
use App\Services\Service\ServicesSorter;


class ItemListBuilder
{
    public function __construct(
        private EloquentProductRepository $productRepository,
        private ServicesSorter $servicesSorter,
        private DataProvider $colorProvider,
        private CountKeysInSetProvider $countKeysInSettProvider,
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

        $services = $this->productRepository->getServicesForProduct($product);
        $services = $this->servicesSorter->sortForCartItem($services);

        $countKeysInSet = $this->countKeysInSettProvider->getCountKeysFromCartItem($product);
        $countAdditionalKeys = $item->getServiceCount(Service::ADD_KEYS_ID);

        $finalProductPrice = $product->price * $count;

        return [
            'product' => $product,
            'count' => $count,
            'color' => $color,
            'services' => $services,
            'finalProductPrice' => $finalProductPrice,
            'defaultCountKeysInSet' => $countKeysInSet,
            'finalCountKeysInSet' => $countKeysInSet + $countAdditionalKeys,
        ];
    }
}
