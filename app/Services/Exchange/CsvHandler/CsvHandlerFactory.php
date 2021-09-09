<?php

namespace App\Services\Exchange\CsvHandler;

/**
 * Class CsvHandlerFactory
 * @package App\Services\Exchange\CsvHandler
 */
class CsvHandlerFactory
{
    /**
     * @var null|string
     */
    private $fileEncoding;
    /**
     * @var null|string
     */
    private $dataEncoding;

    /**
     * @var bool
     */
    private $removeBom;

    /**
     * @param null $fileEncoding
     * @param null $dataEncoding
     * @param bool|false $removeBom
     */
    public function __construct($fileEncoding = null, $dataEncoding = null, $removeBom = false)
    {
        $this->fileEncoding = !is_null($fileEncoding) ? $fileEncoding : 'utf-8';
        $this->dataEncoding = !is_null($dataEncoding) ? $dataEncoding : 'utf-8';
        $this->removeBom = $removeBom;
    }

    /**
     * Get reader for file.
     * @param $file
     * @return CsvReader
     */
    public function getReaderFor($file)
    {
        $callback = null;
        if ($this->fileEncoding != $this->dataEncoding) {
            $callback = function ($readData) {
                return mb_convert_encoding($readData, $this->dataEncoding, $this->fileEncoding);
            };
        }

        return new CsvReader($file, $callback, $this->removeBom);
    }

    /**
     * Get writer for file.
     * @param $file
     * @return CsvWriter
     * @throws \Exception
     */
    public function getWriterFor($file)
    {
        $callback = null;
        if ($this->fileEncoding != $this->dataEncoding) {
            $callback = function ($writeData) {
                return mb_convert_encoding($writeData, $this->fileEncoding, $this->dataEncoding);
            };
        }

        return new CsvWriter($file, $callback);
    }
}
