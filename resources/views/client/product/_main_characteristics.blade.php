@if(!empty($productData['attributesData']['main']))
    <section class="section-product-attributes">
        <div class="container">
            <div class="product-attributes-headline">Основные характеристики</div>

            <div class="product-attributes-grid row">

                @foreach($productData['attributesData']['main'] as $elem)

                    <div class="product-attribute-item col-sm-6 col-md-4 col-xl-2">
                        <div class="product-attribute-thumbnail">
                           {!! $elem['icon'] !!}
                        </div>
                        <div class="product-attribute-title">{{$elem['name']}}</div>
                        <div class="product-attribute-description">{{$elem['values'][0]}}</div>
                        @if($elem['id'] === \App\Models\Attribute\AttributeConstants::COUNT_KEYS_IN_SET_ID)
                            <a href="{{route('service.show', \App\Models\Service::ADD_KEYS_ALIAS)}}" class="product-attribute-link text-muted">Вам недостаточно такого количества? Закажите сейчас со скидкой</a>
                        @endif
                    </div>
                @endforeach

                    <div class="product-attribute-item col-sm-6 col-md-4 col-xl-2">
                        <div class="product-attribute-thumbnail product-attribute-lead-thumbnail text-success">
                            <svg class="product-attribute-media" width="32" height="30">
                                <use xlink:href="{{asset('/images/client/sprite.svg#icon-catalog-master')}}"></use>
                            </svg>
                        </div>

                        <div class="product-attribute-title product-attribute-lead-title text-success">Хотите открывать все двери одним ключом?</div>

                        <a href="javascript:void(0);" class="product-attribute-link product-attribute-lead-link">Расскажем как!</a>
                    </div>
            </div>
        </div>
    </section>
@endif
