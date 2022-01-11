<div class="product-included-block">

    <svg class="product-included-media" width="20" height="20">
        <use xlink:href="{{asset('/images/client/sprite.svg#icon-key')}}"></use>
    </svg>

    <span class="product-included-title">
        В комплекте
        <b>{{$productData['count_keys_in_set']}}
{{--            <span class="text-danger"> + 2</span>--}}
        </b>
        {{\Lang::choice('ключ|ключа|ключей', $productData['count_keys_in_set'])}}
    </span>

    @isset($productData['services']['add_keys'])
        <button type="button" class="product-included-toggle" data-toggle="modal"
                data-target="#modalAddKeys">Добавить еще ключи на всю семью
        </button>
    @endisset

</div>
