<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Service;
use \App\Services\Breadcrumbs\Container as BreadcrumbsContainer;
use App\Services\Cart\Cart;
use App\Services\Cart\ItemListBuilder;
use App\Services\Seo\MetaHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;


class CartController extends Controller
{
    public const PAGE_INFO_CATALOG_PAGE = 'catalog';
    public const PAGE_INFO_PRODUCT_PAGE = 'product';


    public function __construct(
        private Cart $cart,
        private ItemListBuilder $itemListBuilder,
    ){}


    public function show(MetaHelper $metaHelper): View
    {
        $breadcrumbs = $this->getBreadcrumbs();
        $metaData = $metaHelper->getRule()->metaForName('Корзина');

        if($this->cart->isEmpty()){
            return \View::make('client.cart.empty')
                ->with('breadcrumbs', $breadcrumbs)
                ->with('metaData', $metaData);

        }

        $itemListData = $this->itemListBuilder->buildDataFor();

        return \View::make('client.cart.show')
            ->with('breadcrumbs', $breadcrumbs)
            ->with('metaData', $metaData)
            ->with('itemListData', $itemListData);
    }


    public function add(): JsonResponse
    {
        if (!\Request::ajax()){
            \App::abort(404, 'Page not found');
        }

        $id = (int)\Request::get('productId');
        $pageInfo = (string)\Request::get('pageInfo');
        $countAdditionalKeys = (int) \Request::get('countAdditionalKeys');

        $count = (int)\Request::get('count', 1);
        $item = $this->cart->add($id, $count);

        if($countAdditionalKeys > 0){
            $this->cart->setService($id, Service::ADD_KEYS_ID, $countAdditionalKeys);
        }

        return \Response::json([
            'button_in_cart' => $this->getButtonForResponseToAddInCart($pageInfo),
            'modal_title' => 'Товар добавлен в корзину!',
            'modal_body' => \View::make('client.shared.modal._success_in_cart', ['product' => $item->getProduct(), 'count' => $item->getCount(),])->render(),
            'cartItemCount' => $this->cart->summaryCount()
        ]);
    }


    public function update(): JsonResponse
    {
        if (!\Request::ajax()){
            \App::abort(404, 'Page not found');
        }

        $id = \Request::get('productId');
        $count =  \Request::get('count');

        $item = $this->cart->update($id, $count);

        if(is_null($item)){
            throw new \Exception('Didn\'t find the item');
        }

        $summaryItem = $item->getPrice() * $item->getCount();
        $itemSummaryContent = \View('client.cart._order_item_summary')->with('summaryItem', $summaryItem)->render();

        return \Response::json([
            'itemSummaryContent' => $itemSummaryContent,
            'cartItemCount' => $this->cart->summaryCount(),
        ]);
    }


    public function remove(): JsonResponse
    {
        if (!\Request::ajax()){
            \App::abort(404, 'Page not found');
        }

        $this->cart->remove(\Request::get('productId'));

        return \Response::json([
            'countItemsInCart' => $this->cart->summaryCount()
        ]);
    }


    public function updateSummary(): View
    {
        if (!\Request::ajax()){
            \App::abort(404, 'Page not found');
        }

        return \View::make('client.cart._summary_block');
    }


    public function addServiceForItem(): JsonResponse
    {
        if (!\Request::ajax()){
            \App::abort(404, 'Page not found');
        }

        $productId = (int)\Request::get('productId');
        $serviceId = (int)\Request::get('serviceId');
        $count = (int)\Request::get('count');

        $this->cart->setService($productId, $serviceId, $count);

        return \Response::json([
            'count' => $count,
        ]);
    }


    private function getBreadcrumbs(): BreadcrumbsContainer
    {
        $breadcrumbs = resolve(\App\Services\Breadcrumbs\Factory::class)->init();
        $breadcrumbs->add('Главная', route('home'));
        $breadcrumbs->add('Корзина');
        return $breadcrumbs;
    }


    private function getButtonForResponseToAddInCart(string $pageInfo): string
    {
        return match ($pageInfo){
            self::PAGE_INFO_CATALOG_PAGE => \View::make('client.shared.catalog.product.button._in_cart')->render(),
            self::PAGE_INFO_PRODUCT_PAGE => \View::make('client.shared.product.button._in_cart')->render(),
        };
    }
}
