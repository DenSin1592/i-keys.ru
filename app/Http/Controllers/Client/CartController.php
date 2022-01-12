<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\Breadcrumbs\Factory as Breadcrumbs;
use \App\Services\Breadcrumbs\Container as BreadcrumbsContainer;
use App\Services\Cart\Cart;
use App\Services\Cart\CartItem;
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
//        ClientOrderForm $clientOrderForm,
        private Breadcrumbs $breadcrumbs,
        private MetaHelper $metaHelper,
    ){}


    public function show(): View
    {
        $breadcrumbs = $this->getBreadcrumbs();
        $metaData = $this->metaHelper->getRule()->metaForName('Корзина');

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
            $item->addService(Service::ADD_KEYS_ID, $countAdditionalKeys);
            $this->cart->save();
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


    private function getBreadcrumbs(): BreadcrumbsContainer
    {
        $breadcrumbs = $this->breadcrumbs->init();
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
