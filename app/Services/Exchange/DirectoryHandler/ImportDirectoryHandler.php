<?php

namespace App\Services\Exchange\DirectoryHandler;

use App\Services\Exchange\Exception\CannotCreateDirectoryByPath;
use App\Services\Exchange\Exception\NoDirectoryByPath;
use File;
use Symfony\Component\Finder\SplFileInfo;

class ImportDirectoryHandler
{
    protected $importDir;
    protected $importTrashDir;

    /**
     * ImportDirectoryHandler constructor.
     * @param string $importDir
     * @param string $importTrashDir
     */
    public function __construct(string $importDir, string $importTrashDir)
    {
        $this->importDir = $importDir;
        $this->importTrashDir = $importTrashDir;

        if (!is_dir($this->importDir)) {
            throw new NoDirectoryByPath($this->importDir);
        }

        if (!is_dir($this->importTrashDir)) {
            if (!mkdir($this->importTrashDir, 0777, true)) {
                throw new CannotCreateDirectoryByPath($this->importTrashDir);
            }
        }
    }

    public function importDir(): string
    {
        return $this->importDir;
    }

    public function importTrashDir(): string
    {
        return $this->importTrashDir;
    }

    /**
     * @return \Symfony\Component\Finder\SplFileInfo[]
     */
    public function getFilesForImport()
    {
        return File::allFiles($this->importDir);
    }

    /**
     * @param SplFileInfo $file
     * @return bool
     */
    public function moveFileToTrash(SplFileInfo $file): bool
    {
        return File::move($file->getRealPath(), $this->importTrashDir . DIRECTORY_SEPARATOR . $file->getFilename());
    }
}