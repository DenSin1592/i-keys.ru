<?php namespace App\Services\DataProviders\OrderForm\OrderSubForm;

use App\Models\Order;
use App\Services\DataProviders\OrderForm\OrderSubForm;
use App\Services\Eloquent\CollectionExtractor;
use App\Services\Repositories\Category\EloquentCategoryRepository;
use App\Services\Repositories\OrderItem\EloquentOrderItemRepository;
use Request;

/**
 * Class OrderItems
 * @package App\Services\DataProviders\OrderForm\OrderSubForm
 */
class OrderItems implements OrderSubForm
{
    use CollectionExtractor;

    /**
     * @var EloquentOrderItemRepository
     */
    private $orderItemRepository;

    public function __construct(
        EloquentOrderItemRepository $orderItemRepository
    ) {
        $this->orderItemRepository = $orderItemRepository;
    }

    public function provideDataFor(Order $order, array $oldInput)
    {
        $data = [];

        $orderItems = $this->extractFromArray(
            function () {
                return $this->orderItemRepository->newInstance();
            },
            $oldInput,
            'order_items',
            $this->orderItemRepository->allForOrder($order)
        );

        $data['orderItems'] = $orderItems;
        if (is_array($orderItems)) {
            $orderItems = collect($orderItems);
        }
        $data['totalPrice'] = $this->orderItemRepository->getTotalPriceFor($orderItems);

        return $data;
    }
}
