<?php namespace App\Services\FormProcessors\Order\SubProcessor;

use App\Models\Order;
use App\Services\FormProcessors\Order\SubProcessor;
use Arr;
use App\Services\Repositories\OrderItem\EloquentOrderItemRepository;
use App\Services\Repositories\Product\EloquentProductRepository;

/**
 * Class OrderItems
 * @package App\Services\FormProcessors\Order\SubProcessor
 */
class OrderItems implements SubProcessor
{
    private $orderItemsRepository;
    private $productRepository;

    public function __construct(
        EloquentProductRepository $productRepository,
        EloquentOrderItemRepository $orderItemsRepository
    ) {
        $this->orderItemsRepository = $orderItemsRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * Prepare input data.
     *
     * @param $inputData
     * @return mixed
     */
    public function prepareInputData(array $inputData): array
    {
        $orderItemsData = Arr::get($inputData, 'order_items');

        if (is_array($orderItemsData)) {
            $preparedOrderItemsData = [];

            foreach ($orderItemsData as $orderItemId => $orderItemData) {
                $preparedOrderItemsData[$orderItemId] = $this->prepareOrderItemData($orderItemData);
            }

            Arr::set($inputData, 'order_items', $preparedOrderItemsData);
        }

        return $inputData;
    }

    /**
     * Get order item data.
     *
     * @param $inputData
     * @return array
     */
    private function prepareOrderItemData($inputData): array
    {
        $itemData = [
            'name' => null,
            'count' => null,
        ];

        if (isset($inputData['product_id'])) {
            $product = $this->productRepository->findById($inputData['product_id']);
            if (!is_null($product)) {
                $itemData['product_id'] = $product->id;
                $itemData['code_1c'] = $product->code_1c;
                $itemData['name'] = $product->name;
            }
        }

        if (isset($inputData['name'])) {
            $itemData['name'] = $inputData['name'];
        }

        if (isset($inputData['code_1c'])) {
            $itemData['code_1c'] = $inputData['code_1c'];
        }

        if (isset($inputData['count'])) {
            $itemData['count'] = $inputData['count'];
        }

        $itemData['price'] = $inputData['price'];

        return $itemData;
    }


    /**
     * @inheritdoc
     */
    public function saveAfterCreate(Order $order, array $formData): void
    {
        $orderItems = Arr::get($formData, 'order_items', []);

        foreach ($orderItems as $orderItem) {
            $this->orderItemsRepository->createWithOrder($order, $orderItem);
        }
    }

    /**
     * @inheritdoc
     */
    public function saveAfterUpdate(Order $order, array $formData = []): bool
    {
        $changed = false;

        $orderItems = Arr::get($formData, 'order_items');
        if (!is_array($orderItems)) {
            $orderItems = [];
        }


        $newOrderItemIds = array_keys($orderItems);
        $currentItemIds = $this->orderItemsRepository->getIdsFor($order);

        $toAttach = array_diff($newOrderItemIds, $currentItemIds);
        $toDetach = array_diff($currentItemIds, $newOrderItemIds);
        $toUpdate = array_intersect($newOrderItemIds, $currentItemIds);

        foreach ($toAttach as $id) {
            $orderItemData = Arr::get($formData, "order_items.{$id}", []);
            $this->orderItemsRepository->createWithOrder($order, $orderItemData);
            $changed |= true;
        }

        foreach ($toDetach as $id) {
            $orderItem = $this->orderItemsRepository->findById($id);
            if ($orderItem !== null) {
                $this->orderItemsRepository->delete($orderItem);
                $changed |= true;
            }
        }

        foreach ($toUpdate as $id) {
            $orderItem = $this->orderItemsRepository->findById($id);
            if ($orderItem !== null) {
                $orderItemData = Arr::get($formData, "order_items.{$id}", []);
                $changed |= $this->orderItemsRepository->update($orderItem, $orderItemData);
            }
        }

        if ($changed) {
            $order->load('items');
            $order->touch();
        }

        return $changed;
    }
}
