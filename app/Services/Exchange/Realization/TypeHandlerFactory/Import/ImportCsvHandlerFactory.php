<?php

namespace App\Services\Exchange\Realization\TypeHandlerFactory\Import;

use App\Services\Exchange\Core\ITypeHandlerFactory;
use App\Services\Exchange\DirectoryHandler\ImportDirectoryHandler;
use App\Services\Exchange\CsvHandler\CsvHandlerFactory;
use App\Services\Exchange\StatusHandler\ImportStatusHandler;
use App\Services\Exchange\Logger\ImportLogger;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class ImportCsvHandlerFactory
 * Factory to create handlers for import.
 * @package App\Services\Exchange\Realization\TypeHandlerFactory
 */
abstract class ImportCsvHandlerFactory implements ITypeHandlerFactory
{
    protected $logger;
    protected $statusHandler;
    protected $csvHandlerFactory;
    protected $directoryHandler;
    protected $importTrashDir;

    /**
     * ImportCsvHandlerFactory constructor.
     * @param ImportLogger $logger
     * @param ImportStatusHandler $statusHandler
     * @param CsvHandlerFactory $csvHandlerFactory
     * @param ImportDirectoryHandler $directoryHandler
     */
    public function __construct(
        ImportLogger $logger,
        ImportStatusHandler $statusHandler,
        CsvHandlerFactory $csvHandlerFactory,
        ImportDirectoryHandler $directoryHandler
    ) {
        $this->logger = $logger;
        $this->statusHandler = $statusHandler;
        $this->csvHandlerFactory = $csvHandlerFactory;
        $this->directoryHandler = $directoryHandler;
    }

    /**
     * @inheritDoc
     */
    public function getTypeHandlerList()
    {
        $handlerCollection = [];

        $files = $this->directoryHandler->getFilesForImport();
        foreach ($files as $file) {
            if ($this->checkFileName($file)) {
                $handlerCollection[] = $this->importAttributeHandler($file);
            }
        }

        return $handlerCollection;
    }

    protected abstract function importAttributeHandler(SplFileInfo $file);

    protected abstract function getType();

    /**
     * Check if file name matches current handler.
     * @param SplFileInfo $file
     * @return bool
     */
    protected function checkFileName(SplFileInfo $file)
    {
        return preg_match("/^(\d+)_" . $this->getType() . "\.csv$/", $file->getFilename());
    }

    /**
     * Get priority for file name.
     *
     * @param SplFileInfo $file
     * @return int
     */
    protected function getFilePriority(SplFileInfo $file)
    {
        return explode('_', $file->getFilename())[0];
    }

    /**
     * Priority for all handlers with this type
     * @return int
     */
    public function getTypePriority()
    {
        return 1000;
    }
}
