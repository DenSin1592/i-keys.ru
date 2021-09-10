<?php namespace App\Http\Controllers\Admin;

use App;
use App\Http\Controllers\Controller;
use App\Services\DataProviders\OrderForm\OrderForm;
use App\Services\FormProcessors\Order\OrderFormProcessor;
use App\Services\Pagination\FlexPaginator;
use App\Services\Repositories\Order\EloquentOrderRepository;
use App\Services\Mailers\OrderMailer;
use Carbon\Carbon;

/**
 * Class OrdersController
 * @package App\Http\Controllers\Admin
 */
class OrdersController extends Controller
{
    private $repository;
    private $formProcessor;
    private $formDataProvider;
    private $flexPaginator;
    private $orderMailer;

    public function __construct(
        EloquentOrderRepository $repository,
        OrderForm $formDataProvider,
        OrderFormProcessor $formProcessor,
        FlexPaginator $flexPaginator,
        OrderMailer $orderMailer
    ) {
        $this->repository = $repository;
        $this->formProcessor = $formProcessor;
        $this->formDataProvider = $formDataProvider;
        $this->flexPaginator = $flexPaginator;
        $this->orderMailer = $orderMailer;
    }

    public function index()
    {
        $orderList = $this->getOrderList();

        return view('admin.orders.index')
            ->with('orderList', $orderList);
    }

    public function create()
    {
        $order = $this->repository->newInstance();
        $formData = $this->formDataProvider->provideDataFor($order, old());
        $orderList = $this->getOrderList();

        return view('admin.orders.create')
            ->with('orderList', $orderList)
            ->with('formData', $formData);
    }

    public function edit($id)
    {
        $order = $this->repository->findById($id);
        if (null === $order) {
            App::abort(404, 'Order is not found');
        }

        $formData = $this->formDataProvider->provideDataFor($order, old());
        $orderList = $this->getOrderList();

        return view('admin.orders.edit')
            ->with('orderList', $orderList)
            ->with('formData', $formData);
    }

    public function update($id)
    {
        $order = $this->repository->findById($id);
        if (is_null($order)) {
            \App::abort(404, 'Order not found');
        }

        $success = $this->formProcessor->update($order, \Request::except('redirect_to'));
        if (!$success) {
            return \Redirect::route('cc.orders.edit', $order->id)
                ->withErrors($this->formProcessor->errors())->withInput();
        } else {
            if (\Request::get('redirect_to') === 'index') {
                $redirect = \Redirect::route('cc.orders.index', $order->id);
            } else {
                $redirect = \Redirect::route('cc.orders.edit', $order->id);
            }

            return $redirect->with('alert_success', 'Заказ обновлен');
        }
    }

    public function store()
    {
        $order = $this->formProcessor->create(\Request::except('redirect_to'));
        if (null === $order) {
            return \Redirect::route('cc.orders.create')
                ->withErrors($this->formProcessor->errors())->withInput();
        } else {
            if (\Request::get('redirect_to') === 'index') {
                $redirect = \Redirect::route('cc.orders.index', $order->id);
            } else {
                $redirect = \Redirect::route('cc.orders.edit', $order->id);
            }
            $this->orderMailer->sendClientCompleteEmail($order);

            return $redirect->with('alert_success', 'Заказ создан');
        }
    }

    public function destroy($id)
    {
        $order = $this->repository->findById($id);
        if (is_null($order)) {
            \App::abort(404, 'Order not found');
        }
        $this->repository->delete($order);

        return \Redirect::route('cc.orders.index')->with('alert_success', 'Заказ удален');
    }

    private function getOrderList()
    {
        return $this->flexPaginator->make(
            function ($page, $limit) {
                return $this->repository->allByPage($page, $limit);
            },
            'order-pagination-page',
            'order-pagination-limit'
        );
    }
}
