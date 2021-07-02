<?php namespace App\Services\Import\YmlReader;

use App\Services\Import\YmlReader\CollectionIterator\CollectionIterator;

/**
 * Class OfferIterator
 * Iterator for offers in file.
 * @package App\Services\Import\YmlReader
 */
class OfferIterator implements \Iterator
{
    const LIST_TAG = 'offers';
    const ELEMENT_TAG = 'offer';

    /**
     * @var CollectionIterator
     */
    private $iterator;

    /**
     * Fields which should be converted to boolean.
     * @var array
     */
    private $booleanFields = [
        'available',
        'store',
        'pickup',
        'delivery',
        'manufacturer_warranty',
        'adult',
        'downloadable',
    ];


    /**
     * OfferIterator constructor.
     * Create offer iterator from file.
     *
     * @param $file
     */
    public function __construct($file)
    {
        $this->iterator = new CollectionIterator($file, self::LIST_TAG, self::ELEMENT_TAG);
    }


    /**
     * Get current offer.
     *
     * @return array|null
     * @throws Exception\IncorrectSourceDataException
     */
    public function current()
    {
        $current = $this->iterator->current();
        if (!is_null($current)) {
            $offer = $this->transformOffer($current);
        } else {
            $offer = null;
        }

        return $offer;
    }


    /**
     * Move to next offer in iterator.
     *
     * @throws Exception\IncorrectSourceDataException
     */
    public function next()
    {
        $this->iterator->next();
    }


    /**
     * Get offer key.
     *
     * @return mixed|null
     * @throws Exception\IncorrectSourceDataException
     */
    public function key()
    {
        return $this->iterator->key();
    }


    /**
     * Check if there are valid offer in iterator.
     *
     * @return bool
     * @throws Exception\IncorrectSourceDataException
     */
    public function valid()
    {
        return $this->iterator->valid();
    }


    /**
     * Rewind iterator.
     */
    public function rewind()
    {
        $this->iterator->rewind();
    }


    /**
     * Transform offer - simple xml element to array.
     *
     * @param \SimpleXMLElement $xml
     * @return array
     */
    private function transformOffer(\SimpleXMLElement $xml)
    {
        $resultOffer = [];
        foreach ($xml->attributes() as $attrKey => $attrValue) {
            $resultOffer[$attrKey] = (string)$attrValue;
        }
        $pictures = [];
        $paramsElements = [];
        foreach ($xml->children() as $childTag) {
            $tagName = $childTag->getName();
            if ($tagName === 'param') {
                $paramsElements[] = $childTag;
            } elseif ($tagName === 'picture') {
                $pictures[] = (string)$childTag;
            } elseif ($tagName === 'delivery-options' || $tagName === 'pickup-options') {
                $resultOffer[$tagName] = $this->collectOptions($childTag);
            } elseif (!isset($resultOffer[$tagName])) {
                $resultOffer[$tagName] = (string)$childTag;
            }
        }
        $resultOffer = $this->transformBoolean($resultOffer);
        $resultOffer['pictures'] = $pictures;
        $resultOffer['params'] = $this->transformParameters($paramsElements);

        return $resultOffer;
    }


    /**
     * Transform all boolean string values to actual boolean.
     *
     * @param array $offers
     * @return array
     */
    private function transformBoolean(array $offers)
    {
        $resultOffer = [];
        foreach ($offers as $key => $value) {
            if (in_array($key, $this->booleanFields)) {
                if ($value === 'true') {
                    $value = true;
                } elseif ($value === 'false') {
                    $value = false;
                }
            }
            $resultOffer[$key] = $value;
        }

        return $resultOffer;
    }


    /**
     * Transform param xml-elements to arrays.
     *
     * @param \SimpleXMLElement[] $paramsElements
     * @return array
     */
    private function transformParameters(array $paramsElements)
    {
        $valuesDict = [];
        foreach ($paramsElements as $element) {
            $paramAttributes = $element->attributes();
            $name = (string)$paramAttributes['name'];
            $value = trim((string)$element);
            $unit = isset($paramAttributes['unit']) ? (string)$paramAttributes['unit'] : null;
            $resultValue = [$value];
            if (!is_null($unit) && $unit !== '') {
                $resultValue[] = $unit;
            }
            if (!isset($valuesDict[$name])) {
                $valuesDict[$name] = [];
            }
            $valuesDict[$name][] = $resultValue;
        }

        $resultParams = [];
        foreach ($valuesDict as $name => $values) {
            $resultParams[] = [
                'name' => $name,
                'values' => $values,
            ];
        }

        return $resultParams;
    }


    /**
     * Collect default options from options tag.
     *
     * @param \SimpleXMLElement $optionsTag
     * @return array
     */
    private function collectOptions(\SimpleXMLElement $optionsTag)
    {
        $deliveryOptions = [];
        foreach ($optionsTag->children() as $optionTag) {
            $option = [];
            foreach ($optionTag->attributes() as $attrKey => $attrValue) {
                $option[$attrKey] = (string)$attrValue;
            }
            $deliveryOptions[] = $option;
        }

        return $deliveryOptions;
    }
}
