<?php namespace App\Http\Controllers\Admin\Orders;

use Arr;
use App\Models\OrderItem;
use App\Services\Repositories\Category\EloquentCategoryRepository;
use App\Services\Repositories\OrderItem\EloquentOrderItemRepository;
use App\Services\Repositories\Product\EloquentProductRepository;
use Illuminate\Http\JsonResponse;
use Request;
use Response;

/**
 * Class OrderItemsController
 * @package App\Http\Controllers\Admin\Orders
 */
class OrderItemsController
{
    /**
     * @var EloquentOrderItemRepository
     */
    private $orderItemRepository;

    /**
     * @var EloquentProductRepository
     */
    private $productRepository;

    /**
     * @var EloquentCategoryRepository
     */
    private $categoryRepository;

    public function __construct(
        EloquentOrderItemRepository $orderItemRepository,
        EloquentProductRepository $productRepository,
        EloquentCategoryRepository $categoryRepository
    ) {
        $this->orderItemRepository = $orderItemRepository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function loadCategoryTree(): JsonResponse
    {
        $categoryTree = $this->categoryRepository->getPublishedTree();

        $categoryTreeContent = view('admin.orders.form.order_items._popup._left_menu._category_tree')
            ->with('categoryTree', $categoryTree)
            ->render();

        return Response::json(['category_tree' => $categoryTreeContent]);
    }

    public function productList($categoryId): JsonResponse
    {
        $category = $this->categoryRepository->findPublishedById($categoryId);
        if (null === $category) {
            \App::abort(404, 'Category is not found');
        }

        $products = [];
        if ($category->in_tree_publish) {
            $products = $this->productRepository->getPublishedForCategoryInLvl($category->id);
        }

        $productsContent = view('admin.orders.form.order_items._popup._product_list')
            ->with('products', $products)
            ->with('category', $category)
            ->render();

        return Response::json(['products' => $productsContent]);
    }

    public function addProduct($productId): JsonResponse
    {
        $count = Request::get('count');
        $product = $this->productRepository->findById($productId);
        if (null === $product) {
            \App::abort(404, 'Product not found');
        }

        $content = view('admin.orders.form.order_items._popup._selected_product')
            ->with('productId', $product->id)
            ->with('name', $product->name_with_code_1c)
            ->with('count', $count)
            ->render();

        return Response::json(['added_product' => $content]);
    }

    public function save(): JsonResponse
    {
        $appendProducts = Request::get('append_products');
        if (!is_array($appendProducts)) {
            $appendProducts = [];
        }
        $appendServices = Request::get('append_services');
        if (!is_array($appendServices)) {
            $appendServices = [];
        }

        $orderItems = Request::get('order_items');
        if (!is_array($orderItems)) {
            $orderItems = [];
        }

        if (count($orderItems)) {
            $maxOrderItemId = (int)max(array_keys($orderItems));
        } else {
            $maxOrderItemId = (int)OrderItem::max('id');
        }

        $appendedOrderItems = $this->orderItemRepository->buildFromProductsAndServices(
            $appendProducts,
            $appendServices,
            $maxOrderItemId
        );
        $existedOrderItems = $this->orderItemRepository->buildFromOrderItems($orderItems);

        $orderItems = $this->orderItemRepository->merge($existedOrderItems, $appendedOrderItems, $changedIds);

        $orderItemsContent = view('admin.orders.form.order_items._order_item_list')
            ->with('orderItems', $orderItems)
            ->with('changedIds', $changedIds)
            ->render();

        $totalPrice = $this->orderItemRepository->getTotalPriceFor($orderItems);
        $totalPriceContent = view('admin.orders.form.order_items._total_price')
            ->with('totalPrice', $totalPrice)
            ->render();


        return Response::json(
            [
                'order_items_elements' => $orderItemsContent,
                'total_price_element' => $totalPriceContent,
            ]
        );
    }

    public function refreshPrices(): JsonResponse
    {
        $responseData = [];

        $orderItemsData = Request::get('order_items');
        if (!is_array($orderItemsData)) {
            $orderItemsData = [];
        }

        $currentOrderItemId = Request::get('current_order_item_id');

        $orderItems = $this->orderItemRepository->buildFromOrderItems($orderItemsData);
        $currentOrderItem = $orderItems->find($currentOrderItemId);

        if (!is_null($currentOrderItem)) {
            $responseData['summary_price_element'] = view('admin.orders.form.order_items._summary_price')
                ->with('summaryPrice', $currentOrderItem->summary_price)
                ->render();
        }

        $totalPrice = $this->orderItemRepository->getTotalPriceFor($orderItems);

        $responseData['total_price_element'] =
            view('admin.orders.form.order_items._total_price')
                ->with('totalPrice', $totalPrice)
                ->render();

        return Response::json($responseData);
    }

    public function newService(): JsonResponse
    {
        $content = \View::make('admin.orders.form.order_items._popup._service')
            ->render();

        return \Response::json(['service_block' => $content]);
    }

    public function addService(): JsonResponse
    {
        $name = Request::get('name');
        $name = is_string($name) ? trim($name) : '';

        if ($name === '') {
            $content = '';
        } else {
            $content = view('admin.orders.form.order_items._popup._selected_service')
                ->with('name', $name)
                ->render();
        }

        return Response::json(['added_service' => $content]);
    }
}
