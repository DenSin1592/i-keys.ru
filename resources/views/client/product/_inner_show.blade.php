<main class="main-box flex-shrink-0 flex-grow-1">

    <section class="section-product section-gray">

        @include('client.product._product_info')

        @include('client.product._main_characteristics')

        @include('client.product._expert')

        @include('client.product._other_characteristics')


        @isset($productData['relatedProductsData']['locks'])
            @include('client.product._special_related', [
                'header' => 'Замки для этого цилиндра',
                'subheader' => '<span class="section-alert-media">!</span> Мы рекомендуем покупать замок и комплектующие одного производителя',
                'relatedProducts' => $productData['relatedProductsData']['locks'],
                'catalogLink' => route('catalog', \App\Models\Category::LOCKS_ALIAS),
                'catalogImgPath' => asset('/images/client/sprite.svg#icon-catalog-lock'),
                'catalogText' => 'Посмотреть все замки',
            ])
        @endisset


        @isset($productData['relatedProductsData']['cylinders'])
            @include('client.product._special_related', [
                'header' => 'Цилиндры для этого замка',
                'subheader' => 'Мы рекомендуем покупать цилиндр и комплектующие одного производителя',
                'relatedProducts' => $productData['relatedProductsData']['cylinders'],
                'catalogLink' => route('catalog', \App\Models\Category::CYLINDERS_ALIAS),
                'catalogImgPath' => asset('/images/client/sprite.svg#icon-catalog-cylinder'),
                'catalogText' => 'Посмотреть все цилиндры',
            ])
        @endisset


        @isset($productData['services']['general'])
            @include('client.shared._section_services', [
                'services' => $productData['services']['general'],
                'additionalClass' => 'section-product-services'
            ])
        @endisset


        @isset($productData['relatedProductsData']['armorplate'])
            @include('client.product._special_related', [
                'header' => 'Хотите повысить взломостойкость, купите броненакладку',
                'relatedProducts' => $productData['relatedProductsData']['armorplate'],
                'catalogLink' => route('catalog', '/furnitura/bronenakladki-cisa'),
                'catalogImgPath' => asset('/images/client/sprite.svg#icon-catalog'),
                'catalogText' => 'Посмотреть все броненакладки',
            ])
        @endisset

    </section>

    @isset($productData['relatedProductsData']['default'])
        @include('client.product._default_related', [
            'relatedProducts' => $productData['relatedProductsData']['default'],
        ])
    @endisset

</main>
