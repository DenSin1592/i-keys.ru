<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Breadcrumbs\Factory as Breadcrumbs;
use \App\Services\Breadcrumbs\Container as BreadcrumbsContainer;
use App\Services\Cart\Cart;
use App\Services\Cart\ItemListBuilder;
use App\Services\Seo\MetaHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;


class CartController extends Controller
{
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

        if($this->cart->totalCount() === 0){
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
        $count = (int)\Request::get('count', 1);
        $item = $this->cart->add($id, $count);

        return \Response::json([
            'button_in_cart' => \View::make('client.shared.product.button._in_cart')->render(),
            'modal_title' => 'Товар добавлен в корзину!',
            'modal_body' => \View::make('client.shared.modal._success_in_cart', ['product' => $item->getProduct(), 'count' => $item->getCount(),]),
            'cartItemCount' => $this->cart->totalCount()
        ]);
    }


    public function remove(): JsonResponse
    {
        if (!\Request::ajax()){
            \App::abort(404, 'Page not found');
        }

        $this->cart->remove(\Request::get('productId'));

        return \Response::json([
            'countItemsInCart' => $this->cart->totalCount()
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



//    public function update()
//    {
//        if (!\Request::ajax())
//            \App::abort(404, 'Page not found');
//
//        if(!$this->check(Request::get('productId')))
//            return Response::json([
//                'success' => false
//            ]);
//
//        $this->cart->update(Request::get('productId'), Request::get('count'));
//        $this->cart->save();
//
//        $item = $this->cart->getItem(Request::get('productId'));
//        $product = $item->getProduct();
//        $itemData = [
//            'product' => $product,
//            'price' => $product->price,
//            'old_price' => $product->old_price,
//            'count' => $item->getCount(),
//        ];
//        $content = \View('client.cart.show._summary_price')->with('itemData', $itemData)->render();
//
//        return Response::json([
//            'success' => true,
//            'content' => $content
//        ]);
//    }
}
