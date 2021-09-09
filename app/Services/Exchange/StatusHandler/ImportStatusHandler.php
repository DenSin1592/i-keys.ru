<?php

namespace App\Services\Exchange\StatusHandler;

/**
 * Class ImportStatusHandler
 * Status handler.
 * @package App\Services\Exchange\StatusHandler
 */
class ImportStatusHandler
{
    /**
     * @var string
     */
    private $statusFilePath;

    /**
     * @param string $statusFilePath
     */
    public function __construct($statusFilePath)
    {
        $this->statusFilePath = $statusFilePath;
    }

    /**
     * Write status.
     * @param $preparingFile
     * @param $line
     */
    public function writeStatus($preparingFile, $line)
    {
        $data = [
            'file' => $preparingFile,
            'line' => $line,
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $encodedData = json_encode($data);
        file_put_contents($this->statusFilePath, $encodedData);
    }

    /**
     * Get status.
     * @return array
     */
    public function getStatus()
    {
        if (is_file($this->statusFilePath)) {
            $encodedData = file_get_contents($this->statusFilePath);
            $data = json_decode($encodedData, true);
        } else {
            $data = null;
        }

        $result = [
            'file' => isset($data['file']) ? $data['file'] : null,
            'line' => isset($data['line']) ? $data['line'] : null,
            'updated_at' => isset($data['updated_at']) ? $data['updated_at'] : null,
        ];

        return $result;
    }
}
