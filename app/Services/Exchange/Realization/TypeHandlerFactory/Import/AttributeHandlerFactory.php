<?php

namespace App\Services\Exchange\Realization\TypeHandlerFactory\Import;

use App\Services\Exchange\DirectoryHandler\ImportDirectoryHandler;
use App\Services\Exchange\Logger\Import\AttributeLogger;
use App\Services\Exchange\Realization\TypeHandler\Import\AttributeHandler;
use App\Services\Exchange\CsvHandler\CsvHandlerFactory;
use App\Services\Exchange\StatusHandler\ImportStatusHandler;
use App\Services\Repositories\Attribute\EloquentAttributeRepository;
use App\Services\Repositories\Product\EloquentProductRepository;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class AttributeHandlerFactory
 * Factory to create handlers to import attributes.
 * @property-read AttributeLogger $logger
 * @package App\Services\Exchange\Realization\TypeHandlerFactory\Import
 */
class AttributeHandlerFactory extends ImportCsvHandlerFactory
{
    private $attributeRepository;
    private $productRepository;

    /**
     * AttributeHandlerFactory constructor.
     * @param EloquentAttributeRepository $attributeRepository
     * @param EloquentProductRepository $productRepository
     * @param AttributeLogger $logger
     * @param ImportStatusHandler $statusHandler
     * @param CsvHandlerFactory $csvHandlerFactory
     * @param ImportDirectoryHandler $directoryHandler
     */
    public function __construct(
        EloquentAttributeRepository $attributeRepository,
        EloquentProductRepository $productRepository,
        AttributeLogger $logger,
        ImportStatusHandler $statusHandler,
        CsvHandlerFactory $csvHandlerFactory,
        ImportDirectoryHandler $directoryHandler
    ) {
        $this->attributeRepository = $attributeRepository;
        $this->productRepository = $productRepository;

        parent::__construct(
            $logger,
            $statusHandler,
            $csvHandlerFactory,
            $directoryHandler
        );
    }

    protected function importAttributeHandler(SplFileInfo $file)
    {
        return new AttributeHandler(
            $this->attributeRepository,
            $this->productRepository,
            $this->logger,
            $this->statusHandler,
            $this->csvHandlerFactory,
            $this->directoryHandler,
            $file,
            $this->getFilePriority($file),
            );
    }

    protected function getType()
    {
        return 'QList';
    }
}
