<?php namespace App\Services\Import\YmlReader\CollectionIterator;

use App\Services\Import\YmlReader\Exception\IncorrectSourceDataException;

/**
 * Class CollectionIterator
 * Collection iterator for YML files.
 *
 * @package App\Services\Import\YmlReader\CollectionIterator
 */
class CollectionIterator implements \Iterator
{
    private $file;
    private $rootTag;
    private $elementTag;

    /** @var \XMLReader|null */
    private $reader = null;
    private $value = null;
    private $key = null;
    private $end = false;

    /**
     * CollectionIterator constructor.
     * Create YML iterator.
     *
     * @param string $file - path to file
     * @param string $rootTag - root tag of collection
     * @param string $elementTag - tag of element in collection
     */
    public function __construct($file, $rootTag, $elementTag)
    {
        $this->file = $file;
        $this->rootTag = $rootTag;
        $this->elementTag = $elementTag;
    }


    public function __destruct()
    {
        $this->closeReader();
    }


    /**
     * Return current element of collection.
     *
     * @return \SimpleXMLElement|null
     * @throws IncorrectSourceDataException
     */
    public function current()
    {
        $this->loadReader();

        return $this->value;
    }


    /**
     * Move to next element in collection if it's possible.
     *
     * @throws IncorrectSourceDataException
     */
    public function next()
    {
        $this->loadReader();
        $this->readElement();
    }


    /**
     * Get current key.
     *
     * @return mixed|null
     * @throws IncorrectSourceDataException
     */
    public function key()
    {
        $this->loadReader();

        return $this->key;
    }


    /**
     * Check if there are valid element.
     *
     * @return bool
     * @throws IncorrectSourceDataException
     */
    public function valid()
    {
        $this->loadReader();

        return !is_null($this->value);
    }


    /**
     * Rewind iterator.
     */
    public function rewind()
    {
        $this->value = null;
        $this->key = null;
        $this->end = false;
        $this->closeReader();
    }


    /**
     * Start. It will create reader and read first element.
     * @throws IncorrectSourceDataException
     */
    private function loadReader()
    {
        if (is_null($this->reader) && !$this->end) {
            $this->reader = new \XMLReader();
            if (!@$this->reader->open($this->file)) {
                throw new IncorrectSourceDataException($this->file);
            }
            $collectionFound = false;
            while (@$this->reader->read()) {
                if ($this->reader->nodeType == \XMLReader::ELEMENT && $this->reader->localName === $this->rootTag) {
                    $collectionFound = true;
                    break;
                }
            }

            if ($collectionFound) {
                @$this->reader->read(); // go inside collection
                $this->readElement();
            } else {
                $this->makeEnd();
            }
        }
    }


    /**
     * Close reader if it's opened.
     */
    private function closeReader()
    {
        if (!is_null($this->reader)) {
            $this->reader->close();
            $this->reader = null;
        }
    }


    /**
     * End. It will mark as end.
     */
    private function makeEnd()
    {
        $this->value = null;
        $this->key = null;
        $this->end = true;
        $this->closeReader();
    }


    /**
     * Read next element.
     * If it finds the end of elements, it will mark it will make iterator invalid.
     * If it finds actual element, it will be written into iterator with offer index.
     */
    private function readElement()
    {
        if ($this->end) {
            return;
        }

        $elementFound = false;
        do {
            // we have found element
            if ($this->reader->nodeType == \XMLReader::ELEMENT && $this->reader->localName === $this->elementTag) {
                $elementAsXml = @$this->reader->readOuterXml();
                // if string is empty, element is not correct
                if ($elementAsXml !== '') {
                    $this->value = new \SimpleXMLElement($elementAsXml);
                    if (is_null($this->key)) {
                        $this->key = 0;
                    } else {
                        $this->key += 1;
                    }
                    $elementFound = true;
                }
            }

            $terminate = false;

            // end of collection, terminate
            if ($this->reader->nodeType == \XMLReader::END_ELEMENT && $this->reader->localName === $this->rootTag) {
                $terminate = true;
            }

            // move cursor to next element, ignore children
            // if nothing to read, terminate
            if (@$this->reader->next() === false) {
                $terminate = true;
            }

            // terminate the process
            if ($terminate) {
                $this->makeEnd();
                break;
            }
        } while (!$elementFound);
    }
}
