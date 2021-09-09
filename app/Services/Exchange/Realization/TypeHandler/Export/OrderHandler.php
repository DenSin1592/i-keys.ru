<?php

namespace App\Services\Exchange\Realization\TypeHandler\Export;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Exchange\DirectoryHandler\ExportDirectoryHandler;
use App\Services\Exchange\Exception\CannotCopyFile;
use App\Services\Exchange\CsvHandler\CsvHandlerFactory;
use App\Services\Exchange\CsvHandler\CsvWriter;
use App\Services\Exchange\Logger\Export\OrderLogger;
use App\Services\Exchange\Realization\TypeHandler\Export\Features\PreparePhone;
use App\Services\Exchange\StatusHandler\ExportStatusHandler;
use App\Services\Repositories\Order\EloquentOrderRepository;
use App\Services\Repositories\OrderItem\EloquentOrderItemRepository;

/**
 * Class ExportOrderHandler
 * @package App\Services\Exchange\Realization\TypeHandler
 */
class OrderHandler extends ExportCsvHandler
{
    use PreparePhone;

    private $orderRepository;
    private $orderItemRepository;
    protected $logger;
    protected $statusHandler;
    protected $csvHandlerFactory;
    protected $directoryHandler;

    /**
     * OrderHandler constructor.
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

    /**
     * Get priority of this handler.
     * @return int
     */
    public function getPriority()
    {
        return 2;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $orders = $this->orderRepository->getOrdersForExport();
        if ($orders->count() === 0) {
            return;
        }

        $lastFileNumber = $this->statusHandler->getLastFileNumber($this->directoryHandler->exportTmpDir());
        try {
            $lastFileNumber++;
            $fileName = $this->generateFileName($lastFileNumber);

            /** @var CsvWriter $csvWriter */
            $csvWriter = $this->csvHandlerFactory->getWriterFor(
                $this->directoryHandler->filePathToTmpDir($fileName)
            );
            foreach ($orders as $order) {
                /** @var Order $order */
                $orderData = $this->prepareExportData($order);
                foreach ($orderData as $oData) {
                    $csvWriter->putRow($oData);
                }
                $order->markExchangeStatusAsExported();
            }
            unset($csvWriter);

            if (!$this->directoryHandler->copyFileFromTmpToExportDir($fileName)) {
                foreach ($orders as $order) {
                    /** @var Order $order */
                    $order->markExchangeStatusAsChanged();
                }
                throw new CannotCopyFile($fileName, $this->directoryHandler->exportDir());
            }

            $this->statusHandler->writeStatus(
                $this->directoryHandler->filePathToExportDir($fileName),
                $lastFileNumber
            );
        } catch (\Exception $e) {
            $this->logger->addLog("Ошибка экспорта заказов: " . $e->getMessage());
        }
    }

    /**
     * Prepare data to write to csv file
     * @param Order $order
     * @return array
     */
    private function prepareExportData(Order $order)
    {
        $orderData = [];
        $orderItems = $order->items;

        // general order info
        $orderData[] = [
            $order->code_1c,
            isset($order->status) ?
                trans('validation.model_attributes.order.status.' . $order->status) : '',
            isset($order->payment_status) ?
                trans('validation.model_attributes.order.payment_status.' . $order->payment_status) : '',
            (!is_null($order->client) ? $order->client->code_1c : ''),
            (is_null($order->client) ? $order->name : ''),
            $order->email,
            $this->preparePhone($order->phone),
            isset($order->payment_method) ?
                trans('validation.model_attributes.order.payment_method.' . $order->payment_method) : '',
            isset($order->delivery_method) ?
                trans('validation.model_attributes.order.delivery_method.' . $order->delivery_method) : '',
            '', //тариф доставки
            '', //комментарии к тарифу доставки
            $order->postcode,
            !is_null($order->region) ? $order->region->name : '',
            $order->city,
            $order->street,
            $order->building,
            $order->flat,
            $order->comment,
            '', // стоимость доставки
            $order->created_at,
        ];


        $orderItemsData = [];
        foreach ($orderItems as $item) {
            // экспортируем только товары, услуги не экспортируем
            /** @var OrderItem $item */
            if (!$item->isProductItem()) {
                continue;
            }
            $orderItemsData[] = $item->code_1c;
            $orderItemsData[] = $item->count;
            $orderItemsData[] = $item->price;
        }
        $orderData[] = $orderItemsData;
        $orderData[] = []; //empty row - earlier it was for services

        return $orderData;
    }

    protected function getType(): string
    {
        return 'OrdersWebTo1C';
    }
}
