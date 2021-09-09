<?php

namespace App\Services\Exchange\StatusHandler;

use File;

/**
 * Class ExportStatusHandler
 * Status handler.
 * @package App\Services\Exchange\StatusHandler
 */
class ExportStatusHandler
{
    /**
     * @var string
     */
    private $statusFilePath;

    /**
     * @param string $statusFilePath
     */
    public function __construct(string $statusFilePath)
    {
        $this->statusFilePath = $statusFilePath;
    }

    /**
     * Get status.
     * @return array
     */
    public function getStatus(): array
    {
        $data = null;
        try {
            if (File::isFile($this->statusFilePath)) {
                $encodedData = File::get($this->statusFilePath);
                $data = json_decode($encodedData, true);
            }
        } catch (\Exception $e) {
        }

        $result = [
            'file' => data_get($data, 'file'),
            'last' => data_get($data, 'last'),
            'updated_at' => data_get($data, 'updated_at'),
        ];

        return $result;
    }

    public function getLastFileNumber(string $exportTmpDir)
    {
        $statusData = $this->getStatus();
        if (isset($statusData['last'])) {
            return $statusData['last'];
        }

        return $this->scanLastNumber($exportTmpDir);
    }

    public function writeStatus($fileName, $lastNumber)
    {
        $data = ['file' => $fileName, 'last' => $lastNumber, 'updated_at' => date('Y-m-d H:i:s')];
        $encodedData = json_encode($data);
        File::put($this->statusFilePath, $encodedData);
    }

    /**
     * @param string $exportTmpDir
     * @return int
     */
    private function scanLastNumber(string $exportTmpDir): int
    {
        $lastNumber = 0;
        if (File::isDirectory($exportTmpDir)) {
            $files = File::allFiles($exportTmpDir);
            foreach ($files as $file) {
                if (preg_match("/^(\d+)_.+\.csv$/", $file->getFilename(), $matches) &&
                    $lastNumber < $matches[1]
                ) {
                    $lastNumber = $matches[1];
                }
            }
        }

        return $lastNumber;
    }
}
