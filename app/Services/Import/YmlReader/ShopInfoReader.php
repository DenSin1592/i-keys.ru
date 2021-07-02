<?php namespace App\Services\Import\YmlReader;

use App\Services\Import\YmlReader\Exception\IncorrectSourceDataException;

/**
 * Class ShopInfoReader
 * Reader for shop info.
 * @package App\Services\Import\YmlReader
 */
class ShopInfoReader
{
    const SHOP_ELEMENT = 'shop';
    private $infoElements = ['name', 'company', 'url'];

    /**
     * Extract shop info from file.
     *
     * @param $file
     * @return array
     * @throws IncorrectSourceDataException
     */
    public function getShopInfo($file)
    {
        $resultInfo = [];
        foreach ($this->infoElements as $infoElement) {
            $resultInfo[$infoElement] = null;
        }

        $reader = new \XMLReader();
        if (!@$reader->open($file)) {
            throw new IncorrectSourceDataException($file);
        }

        if ($this->moveToShop($reader)) {
            @$reader->read(); // move inside shop element
            $info = $this->extractInfo($reader);
            $resultInfo = array_replace($resultInfo, $info);
        }

        $reader->close();

        return $resultInfo;
    }


    /**
     * Move to shop element in reader.
     * Return if shop element was found.
     *
     * @param \XMLReader $reader
     * @return bool
     */
    private function moveToShop(\XMLReader $reader)
    {
        $shopFound = false;
        while (@$reader->read()) {
            if ($reader->nodeType == \XMLReader::ELEMENT && $reader->localName === self::SHOP_ELEMENT) {
                $shopFound = true;
                break;
            }
        }

        return $shopFound;
    }


    /**
     * Extract info from reader.
     *
     * @param \XMLReader $reader
     * @return array
     */
    private function extractInfo(\XMLReader $reader)
    {
        $info = [];
        $elementsToFind = count($this->infoElements);
        do {
            // if info element was found, read info
            if ($reader->nodeType == \XMLReader::ELEMENT && in_array($reader->localName, $this->infoElements)) {
                $info[$reader->localName] = $reader->readString();
            }

            // if all elements were found, break
            if (count($info) === $elementsToFind) {
                break;
            }

            // if end of root element was found, break
            if ($reader->nodeType == \XMLReader::END_ELEMENT && $reader->localName === self::SHOP_ELEMENT) {
                break;
            }
        } while (@$reader->next());

        return $info;
    }
}
