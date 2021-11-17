@if (count($productsData) > 0)

<div class="catalog-products-block">
    <div class="catalog-products-grid products-grid row">

        @foreach($productsData as $productData)

            @include('client.categories._products_grid._element')

            @if($loop->iteration === 4)
                <div class="product-item col-sm-6 col-md-4 col-lg-3 col-xl-4 d-flex">
                   Тут будет баннер ватсап
                </div>
                @endif

        @endforeach

    </div>
</div>
@endif
