<?php

namespace App\Services\Exchange\Realization\TypeHandlerFactory\Export;

use App\Services\Exchange\Core\ITypeHandlerFactory;
use App\Services\Exchange\DirectoryHandler\ExportDirectoryHandler;
use App\Services\Exchange\CsvHandler\CsvHandlerFactory;
use App\Services\Exchange\Logger\Export\OrderLogger;
use App\Services\Exchange\StatusHandler\ExportStatusHandler;
use App\Services\Exchange\Realization\TypeHandler\Export\OrderHandler;
use App\Services\Repositories\Order\EloquentOrderRepository;
use App\Services\Repositories\OrderItem\EloquentOrderItemRepository;

/**
 * Class OrderHandlerFactory
 * @package App\Services\Exchange\Realization\TypeHandlerFactory\Export
 */
class OrderHandlerFactory implements ITypeHandlerFactory
{
    private $orderRepository;
    private $orderItemRepository;
    private $logger;
    private $statusHandler;
    private $csvHandlerFactory;
    private $directoryHandler;

    /**
     * OrderHandlerFactory constructor.
     * @param EloquentOrderRepository $orderRepository
     * @param EloquentOrderItemRepository $orderItemRepository
     * @param OrderLogger $logger
     * @param ExportStatusHandler $statusHandler
     * @param CsvHandlerFactory $csvHandlerFactory
     * @param ExportDirectoryHandler $directoryHandler
     */
    public function __construct(
        EloquentOrderRepository $orderRepository,
        EloquentOrderItemRepository $orderItemRepository,
        OrderLogger $logger,
        ExportStatusHandler $statusHandler,
        CsvHandlerFactory $csvHandlerFactory,
        ExportDirectoryHandler $directoryHandler
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
        $this->logger = $logger;
        $this->statusHandler = $statusHandler;
        $this->csvHandlerFactory = $csvHandlerFactory;
        $this->directoryHandler = $directoryHandler;
    }

    public function getTypeHandlerList()
    {
        $handlerCollection = [];

        $handlerCollection[] = new OrderHandler(
            $this->orderRepository,
            $this->orderItemRepository,
            $this->logger,
            $this->statusHandler,
            $this->csvHandlerFactory,
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
        return 2;
    }
}
