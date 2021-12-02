<?php

namespace App\Http\Controllers\Client;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Services\Cart\Cart;
use \Illuminate\Http\JsonResponse;


class CartController extends Controller
{
    public function __construct(
        private Cart $cart,
//        ItemListBuilder $itemListBuilder,
//        ClientOrderForm $clientOrderForm,
//        Breadcrumbs $breadcrumbs,
//        MetaHelper $metaHelper,
//        ProductBuilder $productBuilder
    ){}


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
//        //todo:возможно настроить, (может обернуть в Exception)
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


    public function show()
    {

        dd(__METHOD__, $this->cart->items());
//        $itemListData = $this->itemListBuilder->buildDataFor($this->cart->items());
//
//        if (\Request::ajax()) {
//            $summary = view('client.cart.show._summary', [
//                'itemListData' => $itemListData,
//            ])->render();
//            return Response::json(['summary' => $summary]);
//        }
//
//        $breadcrumbs = $this->breadcrumbs->init();
//        $breadcrumbs->add('Корзина', route('cart.show'));
//        $metaData = $this->metaHelper->getRule()->metaForName('Корзина');
//
//        $formData = $this->clientOrderForm->provideData(Request::old());
//
//        return view('client.cart.show')
//            ->with('breadcrumbs', $breadcrumbs)
//            ->with('itemListData', $itemListData)
//            ->with('formData', $formData)
//            ->with($metaData);

    }

//    public function check(int $productId): bool
//    {
//        return $this->cart->checkItem($productId);
//    }


//    public function getCountItem(int $productId)
//    {
//        return $this->cart->getCountItem($productId);
//    }


//    public function getCountChildItem(int $productId, int $childProductId)
//    {
//        return $this->cart->getCountItemChild( $productId, $childProductId);
//    }



//    private function getButtonAddToCartOnOrderSuccess($typePage)
//    {
//        switch ($typePage) {
//            case self::PRODUCT_PAGE_BUTTON:
//                $htmlNewButton = view('client.products.show._buttons._add_to_cart_disable')->render();
//                break;
//
//            case self::PRODUCT_LIST_BUTTON:
//                $htmlNewButton = view('client.shared.products._button._add_to_cart_disable')->render();
//                break;
//
//            default:
//                $htmlNewButton = null;
//        }
//
//        return $htmlNewButton;
//    }
}
