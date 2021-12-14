<button type="button"
        class="card-product-cart d-flex align-items-center justify-content-center event-add-to-cart"
        data-product-id = "{{$product->id}}"
        data-page-info = "{{\App\Http\Controllers\Client\CartController::PAGE_INFO_CATALOG_PAGE}}"
>
    <svg class="card-product-cart-media d-none d-lg-inline" width="16" height="14">
        <use xlink:href="{{asset('/images/client/sprite.svg#icon-cart')}}"></use>
    </svg>
    Купить
</button>
