<?php

namespace App\Http\Controllers\Client;

use App\Exceptions\Handler;
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

        try {
            $id = (int)\Request::get('productId');
            $count = (int)\Request::get('count', 1);
            $item = $this->cart->add($id, $count);

            return \Response::json([
                'button_in_cart' => \View::make('client.shared.product.button._in_cart')->render(),
                'modal_title' => 'Товар добавлен в корзину!',
                'modal_body' => \View::make('client.shared.modal._success_in_cart', ['product' => $item->getProduct(), 'count' => $item->getCount(),])->render(),
                'cartItemCount' => $this->cart->totalCount()
            ]);

        }catch (\Throwable $e){
            resolve(Handler::class)->report($e);
            return \Response::json([
                'button_in_cart' => '',
                'modal_title' => 'Что то пошло не так...',
                'modal_body' => \View::make('client.shared.modal._error')->render(),
            ]);
        }


    }


    private function getBreadcrumbs(): BreadcrumbsContainer
    {
        $breadcrumbs = $this->breadcrumbs->init();
        $breadcrumbs->add('Главная', route('home'));
        $breadcrumbs->add('Корзина');
        return $breadcrumbs;
    }

//    public function addChild()
//    {
//        //try {
//        if (!\Request::ajax())
//            \App::abort(404, 'Page not found');
//
//            $count = (!empty(Request::get('count')) && is_float((float)Request::get('count')))
//                ? (float)Request::get('count')
//                : null;
//
//            if (is_null($count))
//                throw new \Exception();
//
//            $productId = Request::get('productId');
//            $parentProductId = Request::get('parentProductId');
//            $item = $this->cart->addChild($parentProductId, $productId, $count);
//            $this->cart->save();
//
//            if (is_null($item))
//                throw new \Exception();
//
//            $itemListData = $this->itemListBuilder->buildDataFor($this->cart->items());
//            foreach ($itemListData['items'] as $element){
//                if($element['product']->id == $parentProductId){
//                    $itemData = $element;
//                    break;
//                }
//            }
//            $success = true;
//            $content = view('client.cart.show._child_items', ['itemData' => $itemData])->render();
//
//        /*} catch (\Exception $ex) {
//            report($ex);
//            $success = false;
//            $content = '<div class="card-order-attention-title attention-title d-inline-block text-danger">Извините, что то пошло не так. Наши специалисты уже работают над решением проблемы. Пожалуйста, обратитесь к администратору.</div>';
//        }*/
//
//        return \Response::json([
//            'success' => $success,
//            'content' => $content,
//            'countItemsInCart' => $this->cart->count(),
//        ]);
//    }


//    public function remove()
//    {
//        if (!\Request::ajax())
//        \App::abort(404, 'Page not found');
//
//        $this->cart->remove(Request::get('productId'));
//        $this->cart->save();
//
//        return \Response::json([
//            'countItemsInCart' => $this->cart->count()
//        ]);
//    }


//    public function removeChild()
//    {
//        if (!\Request::ajax())
//            \App::abort(404, 'Page not found');
//
//        $parentProductId = Request::get('parentProductId');
//        $this->cart->removeChild($parentProductId, Request::get('productId'));
//        $this->cart->save();
//
//        $itemListData = $this->itemListBuilder->buildDataFor($this->cart->items());
//        foreach ($itemListData['items'] as $element){
//            if($element['product']->id == $parentProductId){
//                $itemData = $element;
//                break;
//            }
//        }
//
//        $success = true;
//        $content = view('client.cart.show._child_items', ['itemData' => $itemData])->render();
//
//        return \Response::json([
//            'success' => $success,
//            'content' => $content,
//            'countItemsInCart' => $this->cart->count()
//        ]);
//    }


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


//    public function updateChild()
//    {
//        if (!\Request::ajax())
//            \App::abort(404, 'Page not found');
//        $count = Request::get('count');
//
//        if($this->getCountChildItem( Request::get('parentProductId'), Request::get('productId'))){
//            $this->cart->updateChild(Request::get('productId'), Request::get('parentProductId'), $count);
//            $this->cart->save();
//        }
//
//       // try {
//            $product = Product::find(Request::get('productId'));
//            $content = \View('client.cart.show._child_item._item_summary', ['product' => $product, 'count' => $count])->render();
//
//            return Response::json([
//                'success' => true,
//                'content' => $content
//            ]);
//
//        /*}catch (\Throwable $ex){
//            return Response::json([]);
//        }*/
//
//    }



}
