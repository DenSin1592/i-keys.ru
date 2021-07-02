<?php namespace App\Services\Import\YmlReader;

use App\Services\Import\YmlReader\CollectionIterator\CollectionIterator;

/**
 * Class OptionsReader
 * Reader for shop options.
 *
 * @package App\Services\Import\YmlReader
 */
class OptionsReader
{
    private $optionsKey;

    /**
     * OptionsReader constructor.
     * @param string $optionsKey - specify options key (root tag for options)
     */
    public function __construct($optionsKey)
    {
        $this->optionsKey = $optionsKey;
    }

    /**
     * Get option key.
     *
     * @return string
     */
    public function getOptionsKey()
    {
        return $this->optionsKey;
    }


    /**
     * Get options from file according to options key.
     *
     * @param $file
     * @return array
     */
    public function getOptions($file)
    {
        $optionsData = [];

        $options = new CollectionIterator($file, $this->optionsKey, 'option');
        foreach ($options as $option) {
            $optionData = [];
            foreach ($option->attributes() as $key => $value) {
                $optionData[$key] = (string)$value;
            }
            $optionsData[] = $optionData;
        }

        return $optionsData;
    }
}
