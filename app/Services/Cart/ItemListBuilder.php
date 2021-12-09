<?php

namespace App\Services\Cart;


class ItemListBuilder
{

    public function buildDataFor(): array
    {
        $itemList = \Cart::items();
        foreach ($itemList as $item) {
            $itemListData[] = [
                'product' => $item->getProduct(),
                'count' => $item->getCount()
            ];
        }

        return [
            'items' => $itemListData,
        ];
    }
}
