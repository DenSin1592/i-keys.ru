<?php namespace App\Services\DataProviders\OrderForm;

use App\Models\Order;
use App\Services\Repositories\Order\EloquentOrderRepository;

/**
 * Class OrderForm
 * @package App\Services\DataProviders\OrderForm
 */
class OrderForm
{
    /** @var OrderSubForm[] */
    private $subFormList = [];

    /**
     * @var EloquentOrderRepository
     */
    private $orderRepository;

    /**
     * OrderForm constructor.
     * @param EloquentOrderRepository $orderRepository
     */
    public function __construct(EloquentOrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }


    /**
     * Add sub form.
     *
     * @param OrderSubForm $subForm
     */
    public function addSubForm(OrderSubForm $subForm)
    {
        $this->subFormList[] = $subForm;
    }

    public function provideDataFor(Order $order, array $oldInput)
    {
        $data = [
            'order' => $order,
            'status_variants' => $this->orderRepository->getStatusVariants(),
            'type_variants' => $this->orderRepository->getTypeVariants(),
            'payment_status_variants' => $this->orderRepository->getPaymentStatusVariants(),
            'payment_method_variants' => $this->orderRepository->getPaymentMethodVariants(true),
            'delivery_method_variants' => $this->orderRepository->getDeliveryMethodVariants(true),
            'exchange_status_variants' => $this->orderRepository->getExchangeStatusVariants(),
        ];

        foreach ($this->subFormList as $subForm) {
            $subFormData = $subForm->provideDataFor($order, $oldInput);
            $data = array_replace($data, $subFormData);
        }

        return $data;
    }
}
