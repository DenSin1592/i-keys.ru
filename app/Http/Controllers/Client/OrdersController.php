<?php

namespace App\Http\Controllers\Client;

//use App\Http\Controllers\Client\Features\CartDataHelper;
//use App\Http\Controllers\Client\Features\DeviceDetection;
use App\Http\Controllers\Controller;
//use App\Models\ClientUser;
use App\Models\MetaPage;
use App\Models\Node;
use App\Models\Order;
//use App\Services\Breadcrumbs\Factory as Breadcrumbs;
//use App\Services\DataProviders\Order\OrderCheckoutProvider;
use App\Services\FormProcessors\Order\ClientOrderFormProcessor;
//use App\Services\Mailers\OrderMailer;
//use App\Services\OrderCheckout\OrderCheckout;
//use App\Services\Repositories\Node\EloquentNodeRepository;
//use App\Services\Repositories\Order\EloquentOrderRepository;
//use App\Services\Seo\MetaHelper;
//use App\Services\Validation\OrderCheckout\OrderCheckoutStep1LaravelValidator;
//use App\Services\Validation\OrderCheckout\OrderCheckoutStep2LaravelValidator;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
//    use CartDataHelper;
//    use DeviceDetection;

//    const DEFAULT_PAGE_NAME = 'Оформление заказа';

//    private $nodeRepository;
//    private $orderRepository;
//    private $orderCheckoutProvider;
//    private $step1Validator;
//    private $step2Validator;
//    private $orderCheckout;
    public $orderFormProcessor;
//    private $metaHelper;
//    private $breadcrumbs;
//    private $orderMailer;

    /**
     * OrdersController constructor.
//     * @param EloquentNodeRepository $nodeRepository
//     * @param EloquentOrderRepository $orderRepository
//     * @param OrderCheckoutProvider $orderCheckoutProvider
//     * @param OrderCheckoutStep1LaravelValidator $step1Validator
//     * @param OrderCheckoutStep2LaravelValidator $step2Validator
//     * @param OrderCheckout $orderCheckout
     * @param ClientOrderFormProcessor $orderFormProcessor
//     * @param MetaHelper $metaHelper
//     * @param Breadcrumbs $breadcrumbs
//     * @param OrderMailer $orderMailer
     */
    public function __construct(
//        EloquentNodeRepository $nodeRepository,
//        EloquentOrderRepository $orderRepository,
//        OrderCheckoutProvider $orderCheckoutProvider,
//        OrderCheckoutStep1LaravelValidator $step1Validator,
//        OrderCheckoutStep2LaravelValidator $step2Validator,
//        OrderCheckout $orderCheckout,
        ClientOrderFormProcessor $orderFormProcessor,
//        MetaHelper $metaHelper,
//        Breadcrumbs $breadcrumbs,
//        OrderMailer $orderMailer
    ) {
//        $this->nodeRepository = $nodeRepository;
//        $this->orderRepository = $orderRepository;
//        $this->orderCheckoutProvider = $orderCheckoutProvider;
//        $this->step1Validator = $step1Validator;
//        $this->step2Validator = $step2Validator;
//        $this->orderCheckout = $orderCheckout;
        $this->orderFormProcessor = $orderFormProcessor;
//        $this->metaHelper = $metaHelper;
//        $this->breadcrumbs = $breadcrumbs;
//        $this->orderMailer = $orderMailer;
    }

//    public function step1(Request $request)
//    {
//        $clientUser = $this->getClientUser();
//        $storageData = $this->orderCheckout->getData($clientUser);
//        $finishedSteps = $this->getFinishedSteps($storageData);
//
//        return \View::make('client.order_checkout_page.step1.show')
//            ->with($this->getStepPageData())
//            ->with('finishedSteps', $finishedSteps)
//            ->with('currentStep', 'step1')
//            ->with($this->orderCheckoutProvider->provideDataForStep1($storageData, $request->old()));
//    }
//
//    public function step1Store(Request $request)
//    {
//        $data = $request->except('_token');
//        if ($this->step1Validator->with($data)->passes()) {
//            $clientUser = $this->getClientUser();
//            $data['step1'] = true;
//            $data['client_id'] = $clientUser->id;
//            $this->orderCheckout->updateData($data, $clientUser);
//
//            return \Redirect::route('order_checkout.step2');
//        } else {
//            return \Redirect::route('order_checkout.step1')->withInput()
//                ->withErrors($this->step1Validator->errors());
//        }
//    }
//
//    public function step2(Request $request)
//    {
//        $clientUser = $this->getClientUser();
//        $storageData = $this->orderCheckout->getData($clientUser);
//        $finishedSteps = $this->getFinishedSteps($storageData);
//        if (!in_array('step1', $finishedSteps)) {
//            return \Redirect::route('order_checkout.step1');
//        }
//
//        return \View::make('client.order_checkout_page.step2.show')
//            ->with($this->getStepPageData())
//            ->with('finishedSteps', $finishedSteps)
//            ->with('currentStep', 'step2')
//            ->with($this->orderCheckoutProvider->provideDataForStep2($storageData, $request->old(), $clientUser));
//    }
//
//    public function step2Store(Request $request)
//    {
//        $clientUser = $this->getClientUser();
//        $data = $request->except('_token');
//        $data['client_id'] = $clientUser->id;
//        if ($this->step2Validator->with($data)->passes()) {
//            $data['step2'] = true;
//            $this->orderCheckout->updateData($data, $clientUser);
//
//            return \Redirect::route('order_checkout.step3');
//        } else {
//            return \Redirect::route('order_checkout.step2')->withInput()
//                ->withErrors($this->step2Validator->errors());
//        }
//    }
//
//    public function step3(Request $request)
//    {
//        $clientUser = $this->getClientUser();
//        $storageData = $this->orderCheckout->getData($clientUser);
//        $finishedSteps = $this->getFinishedSteps($storageData);
//        if (!in_array('step1', $finishedSteps)) {
//            return \Redirect::route('order_checkout.step1');
//        } elseif (!in_array('step2', $finishedSteps)) {
//            return \Redirect::route('order_checkout.step2');
//        }
//
//        return \View::make('client.order_checkout_page.step3.show')
//            ->with($this->getStepPageData())
//            ->with('finishedSteps', $finishedSteps)
//            ->with('currentStep', 'step3')
//            ->with($this->orderCheckoutProvider->provideDataForStep3($storageData, $request->old(), $clientUser));
//    }
//
//    public function step3Store(Request $request)
//    {
//        $inputData = $request->except('_token');
//        $clientUser = $this->getClientUser();
//        $inputData['client_id'] = $clientUser->id;
//        $inputData['name'] = $clientUser->name;
//        $inputData['email'] = $clientUser->email;
//        $inputData['phone'] = $clientUser->phone;
//        $inputData = $this->addDeviceInfo($inputData);
//
//        /** @var Order $createdOrder */
//        $createdOrder = $this->orderFormProcessor->create($inputData);
//        if (is_null($createdOrder)) {
//            return \Redirect::route('order_checkout.step3')
//                ->withErrors($this->orderFormProcessor->errors())->withInput();
//
//        } else {
//            $this->orderCheckout->clear();
//            $this->orderMailer->sendClientCompleteEmail($createdOrder);
//            $this->orderMailer->sendAdminCompleteEmail($createdOrder);
//
//            return \Redirect::route('order')->with('created_order_id', $createdOrder->id);
//        }
//    }
//
//    public function show()
//    {
//        $orderId = \Session::get('created_order_id');
//        if (!isset($orderId)) {
//            return \Redirect::route('cart');
//        }
//        $node = $this->nodeRepository->findByType(Node::TYPE_ORDER_COMPLETE_PAGE, true);
//        $breadcrumbs = $this->breadcrumbs->init();
//        if (!is_null($node)) {
//            /** @var MetaPage $orderCompletePage */
//            $orderCompletePage = \TypeContainer::getContentModelFor($node);
//            $orderCompletePage->node()->associate($node);
//            $metaData = $this->metaHelper->getRule()->metaForObject($orderCompletePage, $node->name);
//            $breadcrumbs->add($node->name, \UrlBuilder::getUrl($node));
//        } else {
//            $pageName = 'Завершение заказа';
//            $orderCompletePage = null;
//            $metaData = $this->metaHelper->getRule()->metaForName($pageName);
//            $breadcrumbs->add($pageName);
//        }
//        /** @var Order $order */
//        $order = $this->orderRepository->findByIdOrFail($orderId);
//        $clientUser = $this->getClientUser();
//
//        return \View::make('client.order_page.show')
//            ->with($metaData)
//            ->with(
//                $node ? [
//                    'authEditLink' => route('cc.meta-pages.edit', $node->id),
//                    'currentNode' => $node,
//                ] : []
//            )
//            ->with(compact('orderCompletePage', 'order', 'clientUser', 'breadcrumbs'));
//    }
//
//    private function getStepPageData(): array
//    {
//        $breadcrumbs = $this->breadcrumbs->init();
//        $breadcrumbs->add(CartController::DEFAULT_PAGE_NAME, route('cart'));
//        $breadcrumbs->add(self::DEFAULT_PAGE_NAME);
//        $metaData = $this->metaHelper->getRule()->metaForName(self::DEFAULT_PAGE_NAME);
//
//        return array_merge(['breadcrumbs' => $breadcrumbs], $metaData);
//    }
//
//    private function getClientUser()
//    {
//        return \Auth::guard('client')->user();
//    }
//
//    private function getFinishedSteps(array $data)
//    {
//        $steps = [];
//        foreach (['step1', 'step2'] as $step) {
//            if (!empty($data[$step])) {
//                $steps[] = $step;
//            } else {
//                break;
//            }
//        }
//
//        return $steps;
//    }

    public function storeFast(Request $request)
    {
        if (!$request->ajax()) {
            \App::abort(404, 'Page is not found');
        }
        $inputData = $request->all();
//        $inputData = $this->addDeviceInfo($inputData);

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

        $orderCompleteContent = '<p>Спасибо за Ваш заказ! Вашему заказу присвоен номер ' . $order->id .
            '. Наш менеджер свяжется с Вами в ближайшее время.</p>';

//        $this->orderMailer->sendAdminCompleteEmail($order);
//        $this->orderMailer->sendClientCompleteEmail($order);

        return \Response::json(
            [
                'status' => 'success',
                'order_complete_content' => $orderCompleteContent,
                'cart_summary_count' => \Cart::summaryCount(),
//                'cart_items_content' => $this->getCartItemsContent(),
//                'top_cart_content' => $this->getTopCartContent(),
//                'cart_empty_content' => $this->getCartEmptyContent(),
            ]
        );
    }
}
