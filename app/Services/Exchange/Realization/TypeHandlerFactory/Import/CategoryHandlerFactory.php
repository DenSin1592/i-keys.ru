<?php

namespace App\Services\Exchange\Realization\TypeHandlerFactory\Import;

use App\Services\Exchange\DirectoryHandler\ImportDirectoryHandler;
use App\Services\Exchange\Logger\Import\CategoryLogger;
use App\Services\Exchange\Realization\TypeHandler\Import\CategoryHandler;
use App\Services\Exchange\CsvHandler\CsvHandlerFactory;
use App\Services\Exchange\StatusHandler\ImportStatusHandler;
use App\Services\Repositories\Category\EloquentCategoryRepository;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class CategoryHandlerFactory
 * Factory to create handlers to import categories.
 * @package App\Services\Exchange\Realization\TypeHandlerFactory\Import
 */
class CategoryHandlerFactory extends ImportCsvHandlerFactory
{
    private $categoryRepository;

    /**
     * CategoryHandlerFactory constructor.
     * @param EloquentCategoryRepository $categoryRepository
     * @param CategoryLogger $logger
     * @param ImportStatusHandler $statusHandler
     * @param CsvHandlerFactory $csvHandlerFactory
     * @param ImportDirectoryHandler $directoryHandler
     */
    public function __construct(
        EloquentCategoryRepository $categoryRepository,
        CategoryLogger $logger,
        ImportStatusHandler $statusHandler,
        CsvHandlerFactory $csvHandlerFactory,
        ImportDirectoryHandler $directoryHandler
    ) {
        parent::__construct(
            $logger,
            $statusHandler,
            $csvHandlerFactory,
            $directoryHandler
        );
        $this->categoryRepository = $categoryRepository;
    }

    protected function importAttributeHandler(SplFileInfo $file)
    {
        return new CategoryHandler(
            $this->categoryRepository,
            $this->logger,
            $this->statusHandler,
            $this->csvHandlerFactory,
            $this->directoryHandler,
            $file,
            $this->getFilePriority($file)
        );
    }

    protected function getType()
    {
        return 'Cat_prod';
    }
}
