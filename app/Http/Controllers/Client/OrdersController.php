<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Client\Features\CartDataHelper;
use App\Http\Controllers\Client\Features\DeviceDetection;
use App\Http\Controllers\Controller;
use App\Services\FormProcessors\Order\ClientOrderFormProcessor;
use App\Services\Mailers\OrderMailer;
use App\Models\Order;
use Illuminate\Http\Request;

//use App\Models\ClientUser;
//use App\Models\MetaPage;
//use App\Models\Node;
//use App\Services\Breadcrumbs\Factory as Breadcrumbs;
//use App\Services\DataProviders\Order\OrderCheckoutProvider;
//use App\Services\OrderCheckout\OrderCheckout;
//use App\Services\Repositories\Node\EloquentNodeRepository;
//use App\Services\Repositories\Order\EloquentOrderRepository;
//use App\Services\Seo\MetaHelper;
//use App\Services\Validation\OrderCheckout\OrderCheckoutStep1LaravelValidator;
//use App\Services\Validation\OrderCheckout\OrderCheckoutStep2LaravelValidator;


class OrdersController extends Controller
{
    use CartDataHelper;
    use DeviceDetection;

//    const DEFAULT_PAGE_NAME = 'Оформление заказа';

//    private $nodeRepository;
//    private $orderRepository;
//    private $orderCheckoutProvider;
//    private $step1Validator;
//    private $step2Validator;
//    private $orderCheckout;
//    public $orderFormProcessor;
//    private $metaHelper;
//    private $breadcrumbs;
//    private $orderMailer;

    /**
     * OrdersController constructor.
     * @param ClientOrderFormProcessor $orderFormProcessor
     * @param OrderMailer $orderMailer
     */
    public function __construct(
//        private EloquentNodeRepository $nodeRepository,
//        private EloquentOrderRepository $orderRepository,
//        private OrderCheckoutProvider $orderCheckoutProvider,
//        private OrderCheckoutStep1LaravelValidator $step1Validator,
//        private OrderCheckoutStep2LaravelValidator $step2Validator,
//        private OrderCheckout $orderCheckout,
//        MetaHelper $metaHelper,
//        Breadcrumbs $breadcrumbs,
        public ClientOrderFormProcessor $orderFormProcessor,
        private OrderMailer $orderMailer
    ) {}

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

        $orderCompleteContent = '<p>Вашему заказу присвоен номер ' . $order->id .
            '. Наш менеджер свяжется с Вами в ближайшее время.</p>';

        try {
            $this->orderMailer->sendAdminCompleteEmail($order);
            $this->orderMailer->sendClientCompleteEmail($order);
        } catch (\Throwable $e){
            //неплохо бы логировать
        }

        return \Response::json(
            [
                'status' => 'success',
                'modal_title' => 'Спасибо за Ваш заказ!',
                'modal_body' => $orderCompleteContent,
// если нужно добавить больше информации для овтета пользователю
//                'cart_items_content' => $this->getCartItemsContent(),
//                'top_cart_content' => $this->getTopCartContent(),
//                'cart_empty_content' => $this->getCartEmptyContent(),
            ]
        );
    }
}
