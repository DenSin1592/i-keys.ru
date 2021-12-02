<?php

namespace App\Services\Storage;


interface ICardStorage
{
    public function getItems(): array;

    public function save(array $items): void;
}
