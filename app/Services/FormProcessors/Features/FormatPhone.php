<?php namespace App\Services\FormProcessors\Features;

/**
 * Class FormatPhone
 * @package App\Services\FormProcessors\Features
 */
trait FormatPhone
{
    protected function preparePhone(array $data)
    {
        // Prepare phone
        if (isset($data['phone']) &&
            preg_match(
                '/^(\+7|8)(\s|\(|-)*(?P<code>\d{3})(\s|\)|-)*(?P<part1>\d{3})(-|\s)*(?P<part2>\d{2})(-|\s)*(?P<part3>\d{2})$/',
                $data['phone'],
                $matches
            )
        ) {
            $data['phone'] = "+7 ({$matches['code']}) {$matches['part1']}-{$matches['part2']}-{$matches['part3']}";
        }

        return $data;
    }
}