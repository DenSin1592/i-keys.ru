<?php

namespace App\Services\Cart;


class ItemListBuilder
{

    public function buildDataFor(): array
    {
        $itemList = \Cart::items();
        foreach ($itemList as $key => $item) {
            $itemListData[$key] = [
                'product' => $item->getProduct(),
                'count' => $item->getCount()
            ];
            $itemListData[$key]['final_price'] = $itemListData[$key]['count'] * (int)$itemListData[$key]['product']->price;
        }

        return [
            'items' => $itemListData,
        ];
    }
}
