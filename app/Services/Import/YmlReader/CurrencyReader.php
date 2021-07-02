<?php namespace App\Services\Import\YmlReader;

use App\Services\Import\YmlReader\CollectionIterator\CollectionIterator;

/**
 * Class CurrencyReader
 * Reader for currencies from YML-file.
 *
 * @package App\Services\Import\YmlReader
 */
class CurrencyReader
{
    const LIST_TAG = 'currencies';
    const ELEMENT_TAG = 'currency';

    /**
     * Extract associative currencies dict form file.
     *
     * @param $file
     * @return array
     */
    public function getCurrencies($file)
    {
        $currencyDict = [];

        $currencies = new CollectionIterator($file, self::LIST_TAG, self::ELEMENT_TAG);
        foreach ($currencies as $currency) {
            $currencyAttributes = $currency->attributes();
            $id = (string)$currencyAttributes['id'];
            $rate = (string)$currencyAttributes['rate'];
            if (is_numeric($rate)) {
                $currencyDict[$id] = (float)$rate;
            } else {
                if (isset($currencyAttributes['plus'])) {
                    $plus = (float)$currencyAttributes['plus'];
                } else {
                    $plus = 0;
                }
                $currencyDict[$id] = [
                    'rate' => $rate,
                    'plus' => $plus,
                ];
            }
        }

        return $currencyDict;
    }
}
