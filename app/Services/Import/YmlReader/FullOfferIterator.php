<?php namespace App\Services\Import\YmlReader;

/**
 * Class FullOfferIterator
 * Iterator for offers in file.
 * Extended with additional data from file.
 * @package App\Services\Import\YmlReader
 */
class FullOfferIterator implements \Iterator
{
    private $offerIterator;
    private $shopInfo;
    private $currencies;
    private $categories;
    private $options;

    public function __construct(
        OfferIterator $offerIterator,
        array $shopInfo,
        array $currencies,
        array $categories,
        array $options
    ) {
        $this->offerIterator = $offerIterator;
        $this->shopInfo = $shopInfo;
        $this->currencies = $currencies;
        $this->categories = $categories;
        $this->options = $options;
    }

    public function current()
    {
        $offer = $this->offerIterator->current();
        if (!is_null($offer)) {
            $offer = $this->prepareOffer($offer);
        }

        return $offer;
    }

    public function next()
    {
        $this->offerIterator->next();
    }

    public function key()
    {
        return $this->offerIterator->key();
    }

    public function valid()
    {
        return $this->offerIterator->valid();
    }

    public function rewind()
    {
        $this->offerIterator->rewind();
    }


    /**
     * Prepare offer - append additional data.
     *
     * @param array $offer
     * @return array
     */
    private function prepareOffer(array $offer)
    {
        $offer = array_replace($offer, $this->preparePrice($offer));
        $offer = array_replace($offer, $this->prepareCategories($offer));
        $offer = array_replace($offer, $this->prepareOptions($offer));
        $offer = array_replace($offer, $this->prepareUrl($offer));
        $offer = array_replace($offer, $this->preparePictures($offer));

        return $offer;
    }


    /**
     * Get full price info for each offer.
     *
     * @param array $offer
     * @return array
     */
    private function preparePrice(array $offer)
    {
        foreach (['price', 'oldprice'] as $priceKey) {
            if (isset($offer[$priceKey])) {
                if (isset($this->currencies[$offer['currencyId']])) {
                    $currencyInfo = $this->currencies[$offer['currencyId']];
                    if (is_array($currencyInfo)) {
                        $offer["preparedPrice:" . $priceKey] = null;
                    } else {
                        $offer["preparedPrice:" . $priceKey] = $offer[$priceKey] * $currencyInfo;
                    }
                    $offer['currencyInfo'] = $currencyInfo;
                } else {
                    $offer["preparedPrice:" . $priceKey] = null;
                    $offer['currencyInfo'] = null;
                }
            }
        }

        return $offer;
    }


    /**
     * Get full category info for each offer.
     *
     * @param array $offer
     * @return array
     */
    private function prepareCategories(array $offer)
    {
        $categoriesData = [];
        $categoryId = $offer['categoryId'];

        while (isset($this->categories[$categoryId])) {
            $categoriesData[] = [
                'id' => $this->categories[$categoryId]['id'],
                'name' => $this->categories[$categoryId]['name'],
            ];
            $categoryId = isset($this->categories[$categoryId]['parentId']) ?
                $this->categories[$categoryId]['parentId'] : null;
        }
        $categoriesData = array_reverse($categoriesData);

        return ['categoriesPath' => $categoriesData];
    }


    /**
     * Prepare options - delivery, pickup, etc.
     *
     * @param $offer
     * @return array
     */
    private function prepareOptions(array $offer)
    {
        foreach (['delivery-options', 'pickup-options'] as $optionsKey) {
            if (!isset($offer[$optionsKey]) && isset($this->options[$optionsKey])) {
                $offer[$optionsKey] = $this->options[$optionsKey];
            }
        }

        return $offer;
    }


    /**
     * Prepare product url.
     *
     * @param array $offer
     * @return array
     */
    private function prepareUrl(array $offer)
    {
        $url = isset($offer['url']) ? $offer['url'] : '';
        $offer['url'] = $this->adjustUrl($url);

        return $offer;
    }


    /**
     * Prepare pictures urls.
     *
     * @param array $offer
     * @return array
     */
    private function preparePictures(array $offer)
    {
        if (isset($offer['pictures'])) {
            $offer['pictures'] = array_map(function ($url) {
                return $this->adjustUrl($url);
            }, $offer['pictures']);
        }

        return $offer;
    }


    /**
     * Adjust url according to shop info url.
     *
     * @param $url
     * @return string
     */
    private function adjustUrl($url)
    {
        if (parse_url($url, PHP_URL_SCHEME) === null && isset($this->shopInfo['url'])) {
            $url = rtrim($this->shopInfo['url'], '/') . '/' . ltrim($url, '/');
        }

        return $url;
    }
}
