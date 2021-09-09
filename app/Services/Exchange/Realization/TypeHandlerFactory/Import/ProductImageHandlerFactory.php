<?php

namespace App\Services\Exchange\Realization\TypeHandlerFactory\Import;

use App\Services\Exchange\Core\ITypeHandlerFactory;
use App\Services\Exchange\DirectoryHandler\ImportImagesDirectory\ImportProductImagesDirectory;
use App\Services\Exchange\Logger\Import\ProductImageLogger;
use App\Services\Exchange\Realization\TypeHandler\Import\ProductImageHandler;
use App\Services\Repositories\Product\EloquentProductRepository;
use App\Services\Repositories\ProductImage\EloquentProductImageRepository;

/**
 * Class ProductImageHandlerFactory
 * Factory to create handlers to import products images.
 * @package App\Services\Exchange\Realization\TypeHandlerFactory\Import
 */
class ProductImageHandlerFactory implements ITypeHandlerFactory
{
    private $productRepository;
    private $productImageRepository;
    private $logger;
    private $directoryHandler;

    /**
     * ProductImageHandlerFactory constructor.
     * @param EloquentProductRepository $productRepository
     * @param EloquentProductImageRepository $productImageRepository
     * @param ProductImageLogger $logger
     * @param ImportProductImagesDirectory $directoryHandler
     */
    public function __construct(
        EloquentProductRepository $productRepository,
        EloquentProductImageRepository $productImageRepository,
        ProductImageLogger $logger,
        ImportProductImagesDirectory $directoryHandler
    ) {
        $this->productRepository = $productRepository;
        $this->productImageRepository = $productImageRepository;
        $this->logger = $logger;
        $this->directoryHandler = $directoryHandler;
    }

    public function getTypeHandlerList()
    {
        $handlerCollection = [];

        $handlerCollection[] = new ProductImageHandler(
            $this->productRepository,
            $this->productImageRepository,
            $this->logger,
            $this->directoryHandler
        );


        return $handlerCollection;
    }

    /**
     * Priority for all images handlers
     * @return int
     */
    public function getTypePriority()
    {
        return 2000;
    }
}
