<?php

namespace App\Services\Exchange\Realization\TypeHandlerFactory\Import;

use App\Services\Exchange\DirectoryHandler\ImportDirectoryHandler;
use App\Services\Exchange\Logger\Import\AttributeValueLogger;
use App\Services\Exchange\Realization\TypeHandler\Import\AttributeValueHandler;
use App\Services\Exchange\CsvHandler\CsvHandlerFactory;
use App\Services\Exchange\StatusHandler\ImportStatusHandler;
use App\Services\Repositories\Attribute\AllowedValue\EloquentAllowedValueRepository;
use App\Services\Repositories\Attribute\EloquentAttributeRepository;
use App\Services\Repositories\Product\EloquentProductRepository;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class AttributeValueHandlerFactory
 * Factory to create handlers to import attribute values.
 * @property-read AttributeValueLogger $logger
 * @package App\Services\Exchange\Realization\TypeHandlerFactory\Import
 */
class AttributeValueHandlerFactory extends ImportCsvHandlerFactory
{
    private $attributeRepository;
    private $attributeAllowedValueRepository;
    private $productRepository;

    /**
     * AttributeValueHandlerFactory constructor.
     * @param EloquentAttributeRepository $attributeRepository
     * @param EloquentAllowedValueRepository $attributeAllowedValueRepository
     * @param EloquentProductRepository $productRepository
     * @param AttributeValueLogger $logger
     * @param ImportStatusHandler $statusHandler
     * @param CsvHandlerFactory $csvHandlerFactory
     * @param ImportDirectoryHandler $directoryHandler
     */
    public function __construct(
        EloquentAttributeRepository $attributeRepository,
        EloquentAllowedValueRepository $attributeAllowedValueRepository,
        EloquentProductRepository $productRepository,
        AttributeValueLogger $logger,
        ImportStatusHandler $statusHandler,
        CsvHandlerFactory $csvHandlerFactory,
        ImportDirectoryHandler $directoryHandler
    ) {
        $this->attributeRepository = $attributeRepository;
        $this->attributeAllowedValueRepository = $attributeAllowedValueRepository;
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
        return new AttributeValueHandler(
            $this->attributeRepository,
            $this->attributeAllowedValueRepository,
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
        return 'QValues';
    }
}
