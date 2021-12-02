<div class="modal-body">
    <form action="#" class="form-modal form">
        <div id="modalAddToCardProductName" class="title-h4 text-secondary">{{$product->name}}
        </div>

        <div class="form-group d-flex align-items-center">
            <label for="modalAddToCartQuantity" class="form-label form-label-column">Кол-во:</label>

            <div class="custom-number custom-control d-flex align-items-center">
{{--                <button type="button"--}}
{{--                        class="custom-number-button custom-number-decrease d-flex align-items-center justify-content-center">--}}
{{--                    <svg class="custom-number-button-media" width="12" height="12">--}}
{{--                        <use xlink:href="{{asset('/images/client/sprite.svg#icon-minus')}}"></use>--}}
{{--                    </svg>--}}
{{--                </button>--}}

                <input type="number" id="modalAddToCartQuantity" class="custom-number-input" value="{{$count}}">

{{--                <button type="button"--}}
{{--                        class="custom-number-button custom-number-increase d-flex align-items-center justify-content-center">--}}
{{--                    <svg class="custom-number-button-media" width="12" height="12">--}}
{{--                        <use xlink:href="{{asset('/images/client/sprite.svg#icon-plus')}}"></use>--}}
{{--                    </svg>--}}
{{--                </button>--}}
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
