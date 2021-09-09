<?php

namespace App\Services\Exchange\DirectoryHandler;

use App\Services\Exchange\Exception\CannotCreateDirectoryByPath;
use App\Services\Exchange\Exception\NoFileByPath;
use File;

class ExportDirectoryHandler
{
    protected $exportDir;
    protected $exportTmpDir;

    /**
     * ExportDirectoryHandler constructor.
     * @param string $exportDir
     * @param string $exportTmpDir
     */
    public function __construct(string $exportDir, string $exportTmpDir)
    {
        $this->exportDir = $exportDir;
        $this->exportTmpDir = $exportTmpDir;

        if (!is_dir($this->exportDir)) {
            if (!mkdir($this->exportDir, 0777, true)) {
                throw new CannotCreateDirectoryByPath($this->exportDir);
            }
        }

        if (!is_dir($this->exportTmpDir)) {
            if (!mkdir($this->exportTmpDir, 0777, true)) {
                throw new CannotCreateDirectoryByPath($this->exportTmpDir);
            }
        }
    }

    public function exportDir(): string
    {
        return $this->exportDir;
    }

    public function exportTmpDir(): string
    {
        return $this->exportTmpDir;
    }

    /**
     * @param string $fileName
     * @return bool
     */
    public function copyFileFromTmpToExportDir(string $fileName): bool
    {
        $pathFrom = $this->filePathToTmpDir($fileName);
        if (!File::isFile($pathFrom)) {
            throw new NoFileByPath($pathFrom);
        }
        $pathTo = $this->filePathToExportDir($fileName);

        return File::copy($pathFrom, $pathTo);
    }

    public function filePathToTmpDir(string $fileName): string
    {
        return $this->exportTmpDir . DIRECTORY_SEPARATOR . $fileName;
    }

    public function filePathToExportDir(string $fileName): string
    {
        return $this->exportDir . DIRECTORY_SEPARATOR . $fileName;
    }
}