<?php

namespace App\Services\Exchange\Realization\TypeHandlerFactory\Import;

use App\Services\Exchange\DirectoryHandler\ImportDirectoryHandler;
use App\Services\Exchange\Logger\Import\ProductLogger;
use App\Services\Exchange\Realization\TypeHandler\Import\ProductHandler;
use App\Services\Exchange\CsvHandler\CsvHandlerFactory;
use App\Services\Exchange\StatusHandler\ImportStatusHandler;
use App\Services\Repositories\Category\EloquentCategoryRepository;
use App\Services\Repositories\Product\EloquentProductRepository;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class ProductHandlerFactory
 * Factory to create handlers to import products.
 * @property-read ProductLogger $logger
 * @package App\Services\Exchange\Realization\TypeHandlerFactory\Import
 */
class ProductHandlerFactory extends ImportCsvHandlerFactory
{
    private $categoryRepository;
    private $productRepository;

    /**
     * ProductHandlerFactory constructor.
     * @param EloquentCategoryRepository $categoryRepository
     * @param EloquentProductRepository $productRepository
     * @param ProductLogger $logger
     * @param ImportStatusHandler $statusHandler
     * @param CsvHandlerFactory $csvHandlerFactory
     * @param ImportDirectoryHandler $directoryHandler
     */
    public function __construct(
        EloquentCategoryRepository $categoryRepository,
        EloquentProductRepository $productRepository,
        ProductLogger $logger,
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
        $this->productRepository = $productRepository;
    }

    protected function importAttributeHandler(SplFileInfo $file)
    {
        return new ProductHandler(
            $this->categoryRepository,
            $this->productRepository,
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
        return 'Goods';
    }
}
