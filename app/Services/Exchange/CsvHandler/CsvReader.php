<?php

namespace App\Services\Exchange\CsvHandler;

/**
 * Class CsvReader
 * @package App\Services\Exchange\CsvHandler
 */
class CsvReader
{
    /**
     * @var resource
     */
    private $fileHandler;
    /**
     * @var callable
     */
    private $prepareDataCallback;

    /**
     * Create reader for file.
     * @param $file
     * @param callable|null $prepareDataCallback
     * @param bool|false $removeBom
     */
    public function __construct($file, callable $prepareDataCallback = null, $removeBom = false)
    {
        if ($removeBom) {
            $content = file_get_contents($file);
            $content = $this->stripBom($content);

            $this->fileHandler = fopen('data://text/csv;base64,' . base64_encode($content), 'rb');
        } else {
            $this->fileHandler = fopen($file, 'r');
        }

        $this->prepareDataCallback = $prepareDataCallback;
    }

    /**
     * Destroy the reader.
     */
    public function __destruct()
    {
        fclose($this->fileHandler);
    }

    /**
     * Get row.
     * @return array|bool
     */
    public function getRow()
    {
        $data = fgetcsv($this->fileHandler, null, ";", "\"", "\\");
        if (!is_null($this->prepareDataCallback) && is_array($data)) {
            $data = array_map($this->prepareDataCallback, $data);
        }

        return $data;
    }

    /**
     * Strip Utf BOM from content.
     *
     * @param $content
     * @return mixed
     */
    private function stripBom($content)
    {
        $bom = pack('H*', 'EFBBBF');
        $content = preg_replace("/^{$bom}/", '', $content);

        return $content;
    }
}
