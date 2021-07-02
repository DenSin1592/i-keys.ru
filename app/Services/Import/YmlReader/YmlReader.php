<?php namespace App\Services\Import\YmlReader;

/**
 * Class YmlReader
 * Reader for YML.
 *
 * @package App\Services\Import\YmlReader
 */
class YmlReader
{
    private $cachedData = [];
    private $file;
    private $shopInfoReader;
    private $currencyReader;
    private $categoryReader;
    private $optionsReaderList;

    /**
     * YmlReader constructor.
     * @param string $file
     * @param ShopInfoReader $shopInfoReader
     * @param CurrencyReader $currencyReader
     * @param CategoryReader $categoryReader
     * @param OptionsReader[] $optionsReaderList
     */
    private function __construct(
        $file,
        ShopInfoReader $shopInfoReader,
        CurrencyReader $currencyReader,
        CategoryReader $categoryReader,
        array $optionsReaderList
    ) {
        $this->file = $file;
        $this->shopInfoReader = $shopInfoReader;
        $this->currencyReader = $currencyReader;
        $this->categoryReader = $categoryReader;
        $this->optionsReaderList = $optionsReaderList;
    }


    /**
     * Get data and cache it. Second call will return cached data.
     *
     * @param $key
     * @param callable $callback
     * @return mixed
     */
    private function getCachedData($key, callable $callback)
    {
        if (!isset($this->cachedData[$key])) {
            $this->cachedData[$key] = call_user_func($callback);
        }

        return $this->cachedData[$key];
    }

    /**
     * Get shop info.
     *
     * @return array
     */
    public function shopInfo()
    {
        return $this->getCachedData('shopInfo', function () {
            return $this->shopInfoReader->getShopInfo($this->file);
        });
    }

    /**
     * Get available currencies.
     *
     * @return array
     */
    public function currencies()
    {
        return $this->getCachedData('currencies', function () {
            return $this->currencyReader->getCurrencies($this->file);
        });
    }

    /**
     * Get available categories.
     *
     * @return array
     */
    public function categories()
    {
        return $this->getCachedData('categories', function () {
            return $this->categoryReader->getCategories($this->file);
        });
    }

    /**
     * Get options like delivery options and pickup options.
     *
     * @return array
     */
    public function options()
    {
        return $this->getCachedData('options', function () {
            $options = [];
            foreach ($this->optionsReaderList as $optionReader) {
                $options[$optionReader->getOptionsKey()] = $optionReader->getOptions($this->file);
            }

            return $options;
        });
    }

    /**
     * Get iterator for offers.
     *
     * @return FullOfferIterator
     */
    public function offers()
    {
        return new FullOfferIterator(
            new OfferIterator($this->file),
            $this->shopInfo(),
            $this->currencies(),
            $this->categories(),
            $this->options()
        );
    }


    /**
     * Create reader from file.
     *
     * @param $file
     * @return YmlReader
     */
    public static function createReader($file)
    {
        return new YmlReader(
            $file,
            new ShopInfoReader(),
            new CurrencyReader(),
            new CategoryReader(),
            [
                new OptionsReader('delivery-options'),
                new OptionsReader('pickup-options'),
            ]
        );
    }
}
