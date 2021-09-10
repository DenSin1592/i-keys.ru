<?php namespace App\Services\Repositories\OrderItem;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\Repositories\Product\EloquentProductRepository;
use Arr;
use Illuminate\Database\Eloquent\Collection;


/**
 * Class EloquentOrderItemsRepository
 * @package  App\Services\Repositories\OrderItems
 */
class EloquentOrderItemRepository
{
    /**
     * @var EloquentProductRepository
     */
    private $productRepository;

    public function __construct(EloquentProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function allForOrder(Order $order): Collection
    {
        return $order->items()->get();
    }

    public function newInstance(array $data = [], $exists = false): OrderItem
    {
        $orderItem = new OrderItem($data);
        $orderItem->exists = $exists;

        return $orderItem;
    }

    public function newInstanceWithOrder(Order $order, array $data = []): OrderItem
    {
        $orderItem = $this->newInstance($data);
        $orderItem->order()->associate($order);

        return $orderItem;
    }

    public function create(array $data): OrderItem
    {
        return OrderItem::create($data);
    }

    public function createWithOrder(Order $order, array $data = []): OrderItem
    {
        $orderItem = $this->newInstanceWithOrder($order, $data);
        $orderItem->save();

        return $orderItem;
    }

    public function findById($id): ?OrderItem
    {
        return OrderItem::find($id);
    }

    public function delete(OrderItem $orderItem): void
    {
        $orderItem->delete();
    }

    public function update(OrderItem $orderItem, array $data): bool
    {
        $changed = false;

        $orderItem->fill($data);
        $dirty = $orderItem->getDirty();

        if (count($dirty) > 0) {
            $changed |= true;
        }

        $orderItem->save();

        return $changed;
    }

    public function getIdsFor(Order $order): array
    {
        return $order->items->pluck('id')->all();
    }

    public function buildFromProductsAndServices(array $products, array $services, int $offsetForId): Collection
    {
        $collection = Collection::make();
        $newId = $offsetForId + 1;

        foreach ($products as $productData) {
            $productId = Arr::get($productData, 'product_id');
            $count = Arr::get($productData, 'count');

            $product = $this->productRepository->findById($productId);
            if (!is_null($product)) {
                $orderItem = $this->newInstance(
                    [
                        'name' => $product->name,
                        'product_id' => $product->id,
                        'code_1c' => $product->code_1c,
                        'price' => $product->price,
                        'count' => $count,
                    ]
                );

                $orderItem->setAttribute('id', $newId++);

                $collection[] = $orderItem;
            }
        }

        foreach ($services as $serviceData) {
            $orderItem = $this->newInstance(
                [
                    'name' => Arr::get($serviceData, 'name'),
                    'price' => 0,
                    'count' => 1,
                ]
            );
            $orderItem->setAttribute('id', $newId++);

            $collection[] = $orderItem;
        }

        return $collection;
    }

    public function buildFromOrderItems(array $orderItems = []): Collection
    {
        $collection = Collection::make();

        foreach ($orderItems as $orderItemId => $orderItemData) {
            $name = Arr::get($orderItemData, 'name');
            $productId = Arr::get($orderItemData, 'product_id');
            $code1c = Arr::get($orderItemData, 'code_1c');
            $price = Arr::get($orderItemData, 'price');
            $count = Arr::get($orderItemData, 'count');

            $orderItem = $this->newInstance(
                [
                    'name' => $name,
                    'product_id' => $productId,
                    'code_1c' => $code1c,
                    'price' => $price,
                    'count' => $count,
                ]
            );

            $orderItem->setAttribute('id', $orderItemId);

            $collection[] = $orderItem;
        }

        return $collection;
    }

    public function merge(Collection $source, Collection $target, &$changedIds = []): Collection
    {
        $merged = Collection::make($source);

        $changedIds = [];
        $mergedIds = [];

        // Merge items
        foreach ($merged as $toMergeItem) {
            $foundItem = $target->first(function (OrderItem $targetItem) use ($toMergeItem) {
                if (!is_null($toMergeItem->product_id)) {
                    return $targetItem->product_id == $toMergeItem->product_id;
                }

                return $targetItem->name == $toMergeItem->name;
            });

            if (!is_null($foundItem)) {
                $toMergeItem->count += $foundItem->count;
                $mergedIds[] = $foundItem->id;
                $changedIds[] = $toMergeItem->id;
            }
        }

        // Append not merged items
        foreach ($target as $toAddItem) {
            if (!in_array($toAddItem->id, $mergedIds)) {
                $merged[] = $toAddItem;
                $changedIds[] = $toAddItem->id;
            }
        }

        return $merged;
    }

    public function getTotalPriceFor($orderItems): float
    {
        return $orderItems->reduce(function ($totalPrice, OrderItem $orderItem) {
            $totalPrice += $orderItem->summary_price;
            return $totalPrice;
        }, 0);
    }
}
