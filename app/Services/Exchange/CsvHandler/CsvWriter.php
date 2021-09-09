<?php

namespace App\Services\Exchange\CsvHandler;

/**
 * Class CsvWriter
 * @package App\Services\Exchange\CsvHandler
 */
class CsvWriter
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
     * Create writer for file.
     * @param $file
     * @param callable|null $prepareDataCallback
     * @throws \Exception
     */
    public function __construct($file, callable $prepareDataCallback = null)
    {
        $this->fileHandler = fopen($file, 'w');

        if (!$this->fileHandler) {
            throw new \Exception("Не удалось создать файл '{$file}'");
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
     * Write string to file
     * @param array $data
     * @return int
     */
    public function putRow(array $data = [])
    {
        if (!is_null($this->prepareDataCallback) && is_array($data)) {
            $data = array_map($this->prepareDataCallback, $data);
        }

        return fputcsv($this->fileHandler, $data, ";", "\"");
    }

    public function csvOutput($fileName)
    {
        header("Content-Type: text/csv");
        header('Content-Disposition: attachment; filename="' . $fileName . '.csv"');
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
        header("Pragma: no-cache"); // HTTP 1.0
        header("Expires: 0"); // Proxies
    }
}
