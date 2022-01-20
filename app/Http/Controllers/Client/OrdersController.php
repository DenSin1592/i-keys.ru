<?php

namespace App\Http\Controllers\Client;

use App\Exceptions\Handler;
use App\Http\Controllers\Client\Features\CartDataHelper;
use App\Http\Controllers\Client\Features\DeviceDetection;
use App\Http\Controllers\Controller;
use App\Services\FormProcessors\Order\ClientOrderFormProcessor;
use App\Services\Mailers\OrderMailer;
use App\Models\Order;
use Illuminate\Http\Request;

//use App\Services\FormProcessors\ClientOrder\ClientOrderProcessor;
//use App\Mail\AdminOrderCreated;
//use App\Mail\ClientOrderCreated;
//use App\Services\Breadcrumbs\Factory as Breadcrumbs;
//use App\Services\Cart\Cart;
//use App\Services\DataProviders\ClientOrder\ClientOrder;
//use App\Services\Repositories\Order\EloquentOrderRepository;
//use App\Services\Seo\MetaHelper;
//use Mail;


class OrdersController extends Controller
{
    use CartDataHelper;
    use DeviceDetection;

    public function __construct(
        public ClientOrderFormProcessor $orderFormProcessor,
        private OrderMailer $orderMailer,
    ) {}

    public function store(Request $request)
    {
        // Redirect back to cart if there are no items
        if (\Cart::isEmpty()) {
            return \Redirect::route('cart.show');
        }
        $inputData = $request->all();
        $inputData = $this->addDeviceInfo($inputData);

        // Create order
        $order = $this->orderFormProcessor->create($inputData);
        if (!is_null($order)) {
            $orderCompleteContent = '<p>Вашему заказу присвоен номер ' . $order->id . '. Наш менеджер свяжется с Вами в ближайшее время.</p>';
            try{
                $this->orderMailer->sendAdminCompleteEmail($order);
                $this->orderMailer->sendClientCompleteEmail($order);
            } catch (\Swift_SwiftException $ex){
                \Log::error($ex->getMessage());
            } catch (\Throwable $ex){
                \Log::error($ex->getMessage());
                resolve(Handler::class)->report($ex);
            }

            return \Response::json(
                [
                    'status' => 'success',
                    'modal_title' => 'Спасибо за Ваш заказ!',
                    'modal_body' => $orderCompleteContent,
                ]
            );

        } else {
            return \Response::json(
                [
                    'status' => 'error',
                    'errors' => $this->orderFormProcessor->errors(),
                ]
            );
        }
    }

    public function storeFast(Request $request)
    {
        if (!$request->ajax()) {
            \App::abort(404, 'Page is not found');
        }
        $inputData = $request->all();
        $inputData = $this->addDeviceInfo($inputData);

        /** @var Order $order */
        $order = $this->orderFormProcessor->createFast($inputData);
        if (is_null($order)) {
            return \Response::json(
                [
                    'status' => 'error',
                    'errors' => $this->orderFormProcessor->errors(),
                ]
            );
        }

        $orderCompleteContent = '<p>Вашему заказу присвоен номер ' . $order->id . '. Наш менеджер свяжется с Вами в ближайшее время.</p>';

        try{
            $this->orderMailer->sendAdminCompleteEmail($order);
            $this->orderMailer->sendClientCompleteEmail($order);
        } catch (\Swift_SwiftException $ex){
            \Log::error($ex->getMessage());
        } catch (\Throwable $ex){
            \Log::error($ex->getMessage());
            resolve(Handler::class)->report($ex);
        }

        return \Response::json(
            [
                'status' => 'success',
                'modal_title' => 'Спасибо за Ваш заказ!',
                'modal_body' => $orderCompleteContent,
            ]
        );
    }
}
