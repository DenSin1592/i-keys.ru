<?php

namespace App\Services\Storage;


class SessionCartStorage implements ICardStorage
{

    private const KEY = 'cart';


    public function getItems(): array
    {
        $items = \Session::get(self::KEY);
        return $this->decode($items);
    }


    public function save(array $items): void
    {
        \Session::put(self::KEY, $this->encode($items));
    }


    private function encode(array $items)
    {
        return json_encode($items);
    }


    private function decode($encoded)
    {
        if (is_string($encoded)) {
            $decoded = json_decode($encoded);
        }

        return isset($decoded) && is_array($decoded) ? $decoded : [];
    }
}
