<?php namespace App\Services\Repositories\Order;

use App\Models\ClientUser;
use App\Models\Exchange;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class EloquentOrderRepository
 * @package  App\Services\Repositories\Order
 */
class EloquentOrderRepository
{
    public function create(array $data)
    {
        return Order::create($data);
    }

    public function update(\Eloquent $order, $data)
    {
        return $order
            ->fill($data)
            ->save();
    }

    public function findById($id): ?Order
    {
        return Order::find($id);
    }

    public function findByIdOrFail($id)
    {
        return Order::findOrFail($id);
    }

    public function newInstance(array $data = [])
    {
        return Order::newModelInstance($data);
    }

    public function delete(Order $order)
    {
        return $order->delete();
    }

    public function allByPage($page, $limit)
    {
        $query = Order::query();
        $this->scopeOrdered($query);

        $total = $query->count();
        $items = $query->skip($limit * ($page - 1))
            ->take($limit)
            ->get();

        return [
            'page' => $page,
            'limit' => $limit,
            'items' => $items,
            'total' => $total,
        ];
    }

    private function scopeOrdered($query)
    {
        return $query->orderBy('created_at', 'DESC');
    }

    public function getStatusVariants()
    {
        $variants = [];
        foreach (Order\StatusConstants::getConstants() as $c) {
            $variants[$c] = trans("validation.model_attributes.order.status.{$c}");
        }

        return $variants;
    }

    public function getTypeVariants()
    {
        $variants = [];
        foreach (Order\TypeConstants::getConstants() as $c) {
            $variants[$c] = trans("validation.model_attributes.order.type.{$c}");
        }

        return $variants;
    }

    public function getPaymentStatusVariants()
    {
        $variants = [];
        foreach (Order\PaymentStatusConstants::getConstants() as $c) {
            $variants[$c] = trans("validation.model_attributes.order.payment_status.{$c}");
        }

        return $variants;
    }

    public function getDeliveryMethodVariants($nullVariant = false)
    {
        $variants = [];
        if ($nullVariant) {
            $variants[''] = trans('validation.attributes.not_chosen');
        }
        foreach (Order\DeliveryMethodConstants::getConstants() as $c) {
            $variants[$c] = trans("validation.model_attributes.order.delivery_method.{$c}");
        }

        return $variants;
    }

    public function getPaymentMethodVariants($nullVariant = false)
    {
        $variants = [];
        if ($nullVariant) {
            $variants[''] = trans('validation.attributes.not_chosen');
        }
        foreach (Order\PaymentMethodConstants::getConstants() as $c) {
            $variants[$c] = trans("validation.model_attributes.order.payment_method.{$c}");
        }

        return $variants;
    }

    public function getExchangeStatusVariants()
    {
        $variants = [];
        foreach (Exchange\StatusConstants::getConstants() as $c) {
            $variants[$c] = trans("validation.model_attributes.exchange_status.{$c}");
        }

        return $variants;
    }

    public function getPrintData(Order $order, bool $admin = false): array
    {
        if ($admin) {
            $orderData[trans('validation.attributes.status')] =
                trans("validation.model_attributes.order.status.{$order->status}");

            $orderData[trans('validation.attributes.type')] =
                trans("validation.model_attributes.order.type.{$order->type}");

            if (!is_null($order->client)) {
                $orderData[trans('validation.model_attributes.client_users.type')] = $order->client->type_name;
            }
        }

        $orderData[trans('validation.attributes.full_name')] = $order->name;
        $orderData[trans('validation.attributes.phone')] = $order->phone;
        $orderData[trans('validation.attributes.email')] = $order->email;

        if (!empty($order->payment_method)) {
            $orderData[trans('validation.attributes.payment_method')] =
                trans("validation.model_attributes.order.payment_method.{$order->payment_method}");
        }

        if (!empty($order->delivery_method)) {
            $orderData[trans('validation.attributes.delivery_method')] =
                trans("validation.model_attributes.order.delivery_method.{$order->delivery_method}");
        }

        $orderData[trans('validation.attributes.postcode')] = $order->postcode;
        if (!is_null($order->region)) {
            $orderData[trans('validation.attributes.region_id')] = $order->region->name;
        }
        $orderData[trans('validation.attributes.city')] = $order->city;
        $orderData[trans('validation.attributes.street')] = $order->street;
        $orderData[trans('validation.attributes.building')] = $order->building;
        $orderData[trans('validation.attributes.flat')] = $order->flat;
        $orderData[trans('validation.attributes.comment')] = $order->comment;

        $orderData = array_filter(
            $orderData,
            function ($v) {
                if (isset($v)) {
                    $v = trim($v);
                }

                return !empty($v);
            }
        );

        return $orderData;
    }

    public function getOrdersForExport()
    {
        return Order::query()
            ->where('exchange_status', '<>', Exchange\StatusConstants::EXPORTED)
            ->with(['items', 'region'])
            ->get();
    }
}
