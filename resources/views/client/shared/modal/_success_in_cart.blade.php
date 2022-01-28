<div class="modal-body" data-cart-product-id="{{$product->id}}">
    <form action="#" class="form-modal form">
        <div class="form-row">
            <div class="col-3 col-sm-2">
                {{-- todo: заменить ссылку --}}
                <a href="#link" class="modal-thumbnail d-flex align-items-center justify-content-center">
                    <img loading="lazy" src="{{$product->getFirstImagePath('image', 'catalog', 'no-image-200x200.png')}}" alt="{{$product->name}}" class="modal-media">
                </a>
            </div>

            <div class="col-9 col-sm-10 align-self-center">
                {{-- todo: заменить ссылку --}}
                <a href="#link" id="modalAddToCardProductName" class="title-h4 text-secondary">{!! $product->name !!}</a>
        
                <div class="form-group d-flex align-items-center">
                    <label for="modalAddToCartQuantity" class="form-label form-label-column">Кол-во:</label>
        
                    <div class="custom-number custom-control d-flex align-items-center">
                        <button type="button"
                                class="custom-number-button custom-number-decrease d-flex align-items-center justify-content-center">
                            <svg class="custom-number-button-media" width="12" height="12">
                                <use xlink:href="{{asset('/images/client/sprite.svg#icon-minus')}}"></use>
                            </svg>
                        </button>
        
                        <input type="number" id="modalAddToCartQuantity" class="custom-number-input update-product-count-in-cart" value="{{$count}}">
        
                        <button type="button"
                                class="custom-number-button custom-number-increase d-flex align-items-center justify-content-center">
                            <svg class="custom-number-button-media" width="12" height="12">
                                <use xlink:href="{{asset('/images/client/sprite.svg#icon-plus')}}"></use>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal-footer">
    <div class="modal-controls-group form-row flex-column flex-md-row">
        <div class="col-md-auto">
            <a href="{{route('cart.show')}}" class="modal-control btn btn-lg">Перейти в корзину</a>
        </div>

        <div class="col-md-auto">
            <button type="button" class="modal-control btn btn-lg btn-secondary" data-dismiss="modal"
                    aria-label="Close">Продолжить покупки
            </button>
        </div>
    </div>
</div>
