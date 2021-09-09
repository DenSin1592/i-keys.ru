<?php


namespace App\Services\Exchange\Realization\TypeHandler\Export\Features;

trait PreparePhone
{
    private function preparePhone($phone)
    {
        if (!is_string($phone)) {
            return '';
        }

        return trim(ltrim($phone, '+7'));
    }
}