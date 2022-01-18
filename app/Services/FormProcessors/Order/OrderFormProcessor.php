<?php

namespace App\Services\FormProcessors\Order;

use App\Models\Order;
use App\Models\Order\PaymentStatusConstants;
use App\Models\Order\StatusConstants;
use App\Models\OrderPaymentConstants;
use App\Services\FormProcessors\Features\FormatPhone;
use App\Services\Repositories\CreateUpdateRepositoryInterface;
use App\Services\Validation\ValidableInterface;

/**
 * Class OrderFormProcessor
 * @package App\Services\FormProcessors\Order
 */
class OrderFormProcessor
{
    use FormatPhone;

    /**
     * @var ValidableInterface
     */
    protected $validator;
    /**
     * @var CreateUpdateRepositoryInterface
     */
    protected $repository;

    /** @var SubProcessor[] */
    private $subProcessorList = [];

    /**
     * @param ValidableInterface $validator
     * @param CreateUpdateRepositoryInterface $repository
     */
    public function __construct(ValidableInterface $validator, CreateUpdateRepositoryInterface $repository)
    {
        $this->validator = $validator;
        $this->repository = $repository;
    }

    /**
     * Create an element.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data = []): ?Order
    {
        $data = $this->prepareInputData($data);
        if ($this->validator->with($data)->passes()) {
            $instance = $this->repository->create($data);
            $this->afterCreate($instance, $data);

            return $instance;
        } else {
            return null;
        }
    }

    /**
     * Update an element.
     *
     * @param $instance
     * @param array $data
     * @return boolean
     */
    public function update($instance, array $data = []): bool
    {
        $data = $this->prepareInputData($data);
        $this->validator->setCurrentId($instance->id);
        if ($this->validator->with($data)->passes()) {
            $this->repository->update($instance, $data);
            $this->afterUpdate($instance, $data);

            return true;
        } else {
            return false;
        }
    }

    /**
     * Get errors.
     *
     * @return array
     */
    public function errors(): array
    {
        return $this->validator->errors();
    }

    /**
     * Prepare input data before validation and creating/updating.
     *
     * @param array $data
     * @return array
     */
    protected function prepareInputData(array $data): array
    {
        $data = $this->preparePhone($data);
        if (!isset($data['type'])) {
            $data['type'] = Order\TypeConstants::FROM_SITE;
            if (isset($data['delivery_method'])) {
                $data = $this->prepareDeliveryData($data);
            }
        }

        if (isset($data['document']) && !is_null($data['document'])) {
            $file = $data['document'];
            $name =  date("Y-m-d_H-i-s") .'_'. $file->getClientOriginalName();
            $file = $file->move('uploads/document_legal_entity/', $name);
            $data['document'] = $name;
        }

        if (!isset($data['status'])) {
            $data['status'] = StatusConstants::NOVEL;
        }

        if (!isset($data['payment_status'])) {
            $data['payment_status'] = PaymentStatusConstants::UNPAID;
        }


        foreach ($this->subProcessorList as $subProcessor) {
            $data = $subProcessor->prepareInputData($data);
        }

        return $data;
    }

    /**
     * Add sub processor.
     *
     * @param SubProcessor $subProcessor
     */
    public function addSubProcessor(SubProcessor $subProcessor): void
    {
        $this->subProcessorList[] = $subProcessor;
    }

    /**
     * Run "after create" processing for sub processors.
     *
     * @param $order
     * @param $data
     */
    protected function afterCreate(Order $order, array $data): void
    {
        foreach ($this->subProcessorList as $subProcessor) {
            $subProcessor->saveAfterCreate($order, $data);
        }
    }

    /**
     * Run "after update" processing for sub processors.
     *
     * @param $order
     * @param $data
     */
    protected function afterUpdate(Order $order, array $data): void
    {
        foreach ($this->subProcessorList as $subProcessor) {
            $subProcessor->saveAfterUpdate($order, $data);
        }
    }

    protected function prepareDeliveryData(array $data): array
    {
        if ($data['delivery_method'] === Order::DELIVERY_COURIER) {
            foreach ($data as $dataKey => $dataValue) {
                if (strpos($dataKey, Order::DELIVERY_CDEK)) {
                    unset($data[$dataKey]);
                } elseif (strpos($dataKey, Order::DELIVERY_COURIER)) {
                    $data[str_replace('*'.Order::DELIVERY_COURIER, '', $dataKey)] = $dataValue;
                }
            }
        } elseif ($data['delivery_method'] === Order::DELIVERY_CDEK) {
            foreach ($data as $dataKey => $dataValue) {
                if (strpos($dataKey, Order::DELIVERY_COURIER)) {
                    unset($data[$dataKey]);
                } elseif (strpos($dataKey, Order::DELIVERY_CDEK)) {
                    $data[str_replace('*'.Order::DELIVERY_CDEK, '', $dataKey)] = $dataValue;
                }
            }
        }
        return $data;
    }
}
