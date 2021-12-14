<button type="button"
        class="product-control product-control-cart btn btn-lg event-add-to-cart"
        data-product-id = "{{$product->id}}"
        data-page-info = "{{\App\Http\Controllers\Client\CartController::PAGE_INFO_PRODUCT_PAGE}}"
       >
    <svg class="product-control-media" width="28" height="25">
        <use xlink:href="{{asset('/images/client/sprite.svg#icon-cart')}}"></use>
    </svg>

    <span class="product-control-text">Купить</span>
</button>
