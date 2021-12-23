@if (count($productsData) > 0)

<div class="catalog-products-block">
    <div class="catalog-products-grid products-grid row">

        @foreach($productsData as $key => $productData)

                @include('client.categories._products_grid._product_card', [
                    'productData' => $productData,
                    'cardClass' => null,
                    'cardNumber' => $key,
                ])

            @if($loop->iteration === 4 && trim(Setting::get("site_content.wa_phone")) !== '')
                <div class="product-item col-sm-6 col-md-4 col-lg-3 col-xl-4 d-flex">
                    <a href="https://wa.me/{{Setting::get("site_content.wa_phone")}}" class="card-banner card-banner-portrait card-banner-whatsapp d-flex flex-column align-items-center justify-content-center">
                        <div class="card-banner-thumbnail">
                            <img loading="lazy" src="{{asset('/images/client/icons/icon-whatsapp-white.svg')}}" width="125" height="124" alt="Связаться по WhatsApp" class="card-banner-media">
                        </div>

                        <div class="card-banner-title title-h3">Свяжитесь с нами по WhatsApp</div>

                        <div class="card-banner-description">Если у вас появились вопросы в выборе замка. Мы с радостью Вас проконсультируем.</div>
                    </a>
                </div>
                @endif

        @endforeach

    </div>
</div>
@endif
