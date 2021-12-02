<?php

namespace App\Services\Storage;


class CookieCartStorage implements ICardStorage
{

    private const KEY = 'cart';


    public function getItems(): array
    {
        $items = \Cookie::get(self::KEY);
        return $this->decode($items);
    }


    public function save(array $items): void
    {
        \Cookie::queue(\Cookie::forever(self::KEY, $this->encode($items)));
    }



    private function encode(array $items)
    {
        return json_encode($items);
    }


    private function decode($encoded)
    {
        $decoded = [];
        if (is_string($encoded)) {
            $decoded = json_decode($encoded, true);
            if (!is_array($decoded)) {
                $decoded = [];
            }
        }

        return $decoded;
    }
}
