<?php

namespace App\Services\Cart;

use App\Models\Service;
use App\Services\Repositories\Product\EloquentProductRepository;
use App\Services\Storage\ICardStorage;


class Cart
{
    private ?array $itemsCache = null;


    public function __construct(
        private EloquentProductRepository $productRepository,
        private ICardStorage $storage,
    ){}


    public function items(): array
    {
        if (is_null($this->itemsCache)) {
            $this->itemsCache = $this->loadItems();
        }

        return $this->itemsCache;
    }


    public function itemCount($productId): int
    {
        $item = $this->findItem($productId);
        if (!is_null($item)) {
            return $item->getCount();
        }

        return 0;
    }


    public function isEmpty(): int
    {
        return count($this->items()) === 0;
    }


    public function summaryCount()
    {
        return array_reduce(
            $this->items(),
            static function ($summary, $item) {
                $summary += $item->getCount();
                return $summary;
            },
            0
        );
    }


    public function totalPrice()
    {
        return array_reduce(
            $this->items(),
            static function ($summary, $item) {
                $summary += ($item->getPrice() * $item->getCount());
                $services = $item->getServices();
                foreach ($services as $service){
                    $summary += $service->getPrice() * $service->getCount();
                }

                return $summary;
            },
            0
        );
    }


    public function add(int $productId, int $count): CartItem
    {
        $product = $this->productRepository->findPublishedById($productId);

        if (is_null($product) && $count < 1) {
            throw new RuntimeException("Unable to add product to cart. ProductId = $productId. Count = $count.");
        }

        $resultItem = $this->findItem($product->id);

        if (is_null($resultItem)) {
            $itemList = $this->items();
            $resultItem = new CartItem($product, $count);
            $itemList[] = $resultItem;
            $this->setItems($itemList);
            $this->save();
        } else {
            $resultItem->setCount($resultItem->getCount() + $count);
            $this->save();
        }


        return $resultItem;
    }



    public function update(int $productId, int $count): ?CartItem
    {
        $item = $this->findItem($productId);

        if (is_null($item) && $count > 0) {
            return null;
        }
        $item->setCount($count);
        $this->save();

        return $item;
    }


    public function remove($productId)
    {
        $itemList = $this->items();
        $newItemList = array_filter(
            $itemList,
            static function (CartItem $item) use ($productId) {
                return $item->getProduct()->id != $productId;
            }
        );
        $this->setItems($newItemList);
        $this->save();
    }


    public function clear()
    {
        $this->setItems([]);
        $this->save();
    }


    public function findItem(int $productId): ?CartItem
    {
        foreach ($this->items() as $item) {
            if ($item->getProduct()->id === $productId) {
                return $item;
            }
        }

        return null;
    }


    public function checkItem(int $productId): bool
    {
        if(is_null($this->findItem($productId))){
            return false;
        }
        return true;
    }

    public function getCountService(int $productId, int $serviceId): int
    {
        $item = $this->findItem($productId);

        return $item?->getServices()[$serviceId] ?? 0;
    }


    public function checkService(int $productId, int $serviceId): bool
    {
        $item = $this->findItem($productId);

        return $item->checkService($serviceId);
    }


    public function getTotalServicesCount(): int
    {
        $count = 0;
        $items = $this->items();

        foreach ($items as $element){
            $count += count($element->getServices());
        }

        return $count;
    }


    public function setService(int $itemId, int $serviceId, int $count)
    {
        $item = $this->findItem($itemId);
        if(is_null($item)){
            throw new \Exception('CartItem not search');
        }

        $service = Service::find($serviceId);
        if(is_null($service)){
            throw new \Exception('Service in DB not search');
        }

        $item->setService($service, $count);
        $this->save();
    }


    private function save()
    {
        $itemListData = [];
        foreach ($this->items() as $key => $item) {
            $itemListData[$key] = ['product_id' => $item->getProduct()->id, 'count' => $item->getCount(), 'services' => []];
            foreach ($item->getServices() as $serviceId => $serviceItem){
                if(($serviceCount = $serviceItem->getCount()) > 0){
                    $itemListData[$key]['services'][] = ['service_id' => $serviceId, 'count' => $serviceCount];
                }
            }
        }

        $this->storage->save($itemListData);
    }

    private function setItems(array $items)
    {
        $this->itemsCache = $items;
    }


    private function loadItems()
    {
        $rawItemListData = $this->storage->getItems();
        $itemListData = [];
        $productIds = [];
        foreach ($rawItemListData as $key => $itemData) {
            $productId = (int)data_get($itemData, 'product_id');
            $count = (int)data_get($itemData, 'count');
            $itemData['services'] = data_get($itemData, 'services', []);

            if (empty($productId) || $count < 1) {
                continue;
            }
            $itemListData[$key] = [
                'product_id' => $productId,
                'count' => $count,
                'services' => [],
            ];
            $productIds[] = $productId;

            $itemListData[$key]['services'] = $this->loadServices($itemData['services']);
        }

        $productsKeyById = $this->productRepository->getPublishedByIds($productIds)->keyBy('id');
        $items = [];
        foreach ($itemListData as $itemData) {
            $product = $productsKeyById->get($itemData['product_id']);
            if (is_null($product)) {
                continue;
            }
            $items[] = new CartItem($product, $itemData['count'], $itemData['services']);
        }

        return $items;
    }


    private function loadServices(array $services): array
    {
        $finalServices = [];

        foreach ($services as $service){
            $serviceId = (int)data_get($service, 'service_id');
            $count = (int)data_get($service, 'count');

            if (empty($serviceId) || $count < 1) {
                continue;
            }

            $itemListData[] = [
                'service_id' => $serviceId,
                'count' => $count,
            ];
            $serviceIds[] = $serviceId;
        }

        if(!isset($serviceIds)){
            return $finalServices;
        }

        $servicesKeyByid = Service::query()->where('publish', true)->whereIn('id', $serviceIds)->get()->keyBy('id');

        foreach ($itemListData as $itemData) {
            $service = $servicesKeyByid->get($itemData['service_id']);
            if (is_null($service)) {
                continue;
            }
            $finalServices[$itemData['service_id']] = new CartItemService($service, $itemData['count']);
        }

        return $finalServices;
    }
}
