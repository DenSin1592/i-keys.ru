@extends('client.layouts.default')

@section('body_class')
    class='product-page d-flex flex-column'
@endsection

@section('content')
    <main class="main-box flex-shrink-0 flex-grow-1">

        <section class="section-product section-gray">

            @include('client.product._product_info')

            @include('client.product._main_characteristics')

            @include('client.product._expert')

            @include('client.product._other_characteristics')


            @if(isset($productData['relatedProductsData']['locks']))
                @include('client.product._special_related', [
                    'header' => 'Замки для этого товара',
                    'subheader' => 'Мы рекомендуем покупать замок и комплектующие одного производителя',
                    'relatedProducts' => $productData['relatedProductsData']['locks'],
                    'catalogLink' => route('catalog', \App\Models\Category::LOCKS_ALIAS),
                    'catalogImgPath' => asset('/images/client/sprite.svg#icon-catalog-lock'),
                    'catalogText' => 'Посмотреть все замки',
                ])
            @endif

            @include('client.product._services')

            @if(isset($productData['relatedProductsData']['armorplate']))
                @include('client.product._special_related', [
                    'header' => 'Хотите повысить взломостойкость, купите броненакладку',
                    'relatedProducts' => $productData['relatedProductsData']['armorplate'],
                    'catalogLink' => route('catalog', '/furnitura/bronenakladki-cisa'),
                    'catalogImgPath' => asset('/images/client/sprite.svg#icon-catalog'),
                    'catalogText' => 'Посмотреть все броненакладки',
                ])
            @endif

        </section>

        @if(isset($productData['relatedProductsData']['default']))
            @include('client.product._default_related', [
                'relatedProducts' => $productData['relatedProductsData']['default'],
            ])
        @endif

    </main>
@stop
