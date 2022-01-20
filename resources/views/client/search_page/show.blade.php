@extends('client.layouts.default')


@section('body_class')
    class='search-page d-flex flex-column section-gray'
@endsection


@section('content')
    <main class="main-box flex-shrink-0 flex-grow-1">

        <section class="section-display section-dark" >
            <div class="container">
                @include('client.shared.breadcrumbs._breadcrumbs')

                <h1 class="display-title title-h1 text-uppercase">{{$metaData['h1']}}</h1>
                <div class="display-subtitle title-h4 d-flex">
                    <svg class="display-subtitle-media" width="24" height="25">
                        <use xlink:href="{{asset('/images/client/sprite.svg#icon-search')}}"></use>
                    </svg>

                    @if ($paginator->total() > 0)
                        Найдено {{ trans_choice('messages.product', $paginator->total()) }} по запросу "{{ $query }}".
                    @else
                        <p>По запросу "{{ $query }}" не найдено ни одного товара.</p>
                    @endif
                </div>
            </div>
        </section>

        @if ($paginator->total() > 0)
            <section class="section-search">
            <div class="container">
                <div class="search-products-block">
                    <ul class="search-nav-tabs nav nav-tabs d-flex flex-nowrap" role="tablist">
{{--                        <li class="nav-item" role="presentation">--}}
{{--                            <a class="nav-link active" id="search-tab-1" data-toggle="tab" href="#search-pane-1" role="tab" aria-controls="search-pane-1" aria-selected="true">Все</a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item" role="presentation">--}}
{{--                            <a class="nav-link" id="search-tab-2" data-toggle="tab" href="#search-pane-2" role="tab" aria-controls="search-pane-2" aria-selected="false">Замки</a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item" role="presentation">--}}
{{--                            <a class="nav-link" id="search-tab-3" data-toggle="tab" href="#search-pane-3" role="tab" aria-controls="search-pane-3" aria-selected="false">Ручки</a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item" role="presentation">--}}
{{--                            <a class="nav-link" id="search-tab-4" data-toggle="tab" href="#search-pane-4" role="tab" aria-controls="search-pane-4" aria-selected="false">Фурнитура</a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item" role="presentation">--}}
{{--                            <a class="nav-link" id="search-tab-5" data-toggle="tab" href="#search-pane-5" role="tab" aria-controls="search-pane-5" aria-selected="false">Другое</a>--}}
{{--                        </li>--}}
                    </ul>

                    <div class="search-tab-content tab-content">
                        <div class="tab-pane fade show active" id="search-pane-1" role="tabpanel" aria-labelledby="search-tab-1" >
                            <div class="search-products-grid products-grid row">

                                @foreach($productsData as $key => $productData)
                                    <div class="product-item col-sm-6 col-md-4 col-lg-3 d-flex">
                                        @include('client.categories._products_grid._product_card', [
                                            'productData' => $productData,
                                            'cardNumber' => $key,
                                        ])
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{--<div class="tab-pane fade" id="search-pane-2" role="tabpanel" aria-labelledby="search-tab-2" >
                            <div class="search-products-grid products-grid row">

                                <div class="product-item col-sm-6 col-md-4 col-lg-3 d-flex">
                                    <div class="card-product card-product-portrait">
                                        <div class="card-product-badges d-flex">
                                            <div class="card-product-badge">
                                                <svg class="card-product-badge-media" width="39" height="45">
                                                    <use xlink:href="images/sprite.svg#icon-coding"></use>
                                                </svg>
                                            </div>

                                            <div class="card-product-badge">
                                                <svg class="card-product-badge-media" width="45" height="45">
                                                    <use xlink:href="images/sprite.svg#icon-no-keys"></use>
                                                </svg>
                                            </div>
                                        </div>

                                        <a href="product.html" class="card-product-thumbnail">
                                            <img loading="lazy" src="uploads/catalog/product-image-1.jpg" alt="Цилиндр с вертушкой Фабрика замков E AL 60 CP Т01" class="card-product-media">
                                        </a>

                                        <a href="product.html" class="card-product-title">Цилиндр с вертушкой Фабрика замков E AL 60 CP Т01</a>

                                        <div class="card-product-info-list">
                                            <div class="card-product-size-block card-product-info-block d-flex">
                                                <label for="card-product-size-21" class="card-product-info-title card-product-size-title">Типоразмер</label>

                                                <select name="" id="card-product-size-21" class="card-product-size custom-control custom-select" style="width: auto;" >
                                                    <option value="50*60мм">50*60мм</option>
                                                    <option value="60*70мм">60*70мм</option>
                                                </select>
                                            </div>

                                            <div class="card-product-color-block card-product-info-block d-flex">
                                                <label for="" class="card-product-info-title card-product-color-title">Цвет</label>

                                                <div class="card-product-color-list d-flex flex-wrap">
                                                    <div class="card-product-color custom-control custom-color custom-color-sm">
                                                        <input type="radio" class="custom-control-input" id="card-product-color-21-1" name="card-product-color-21" checked >
                                                        <label for="card-product-color-21-1" class="custom-control-label">
                                                            <img loading="lazy" src="uploads/colors/color-brown.png" alt="Коричневый" class="custom-control-image">
                                                        </label>
                                                    </div>

                                                    <div class="card-product-color custom-control custom-color custom-color-sm">
                                                        <input type="radio" class="custom-control-input" id="card-product-color-21-2" name="card-product-color-21" >
                                                        <label for="card-product-color-21-2" class="custom-control-label">
                                                            <img loading="lazy" src="uploads/colors/color-silver.png" alt="Серебряный" class="custom-control-image">
                                                        </label>
                                                    </div>

                                                    <div class="card-product-color custom-control custom-color custom-color-sm">
                                                        <input type="radio" class="custom-control-input" id="card-product-color-21-3" name="card-product-color-21" >
                                                        <label for="card-product-color-21-3" class="custom-control-label">
                                                            <img loading="lazy" src="uploads/colors/color-black.png" alt="Черный" class="custom-control-image">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-product-order-block mt-auto">
                                            <div class="form-row flex-nowrap">
                                                <div class="card-product-price-container col">
                                                    <div class="card-product-price-block d-flex flex-wrap">
                                                        <div class="card-product-price">187<span class="rouble">руб.</span></div>
                                                    </div>
                                                </div>

                                                <div class="card-product-cart-container col-auto">
                                                    <button type="button" class="card-product-cart d-flex align-items-center justify-content-center" data-toggle="modal" data-target="#modalAddToCart" >
                                                        <svg class="card-product-cart-media d-none d-lg-inline" width="16" height="14">
                                                            <use xlink:href="images/sprite.svg#icon-cart"></use>
                                                        </svg>
                                                        Купить
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane fade" id="search-pane-3" role="tabpanel" aria-labelledby="search-tab-3" >
                            <div class="search-products-grid products-grid row">

                                <div class="product-item col-sm-6 col-md-4 col-lg-3 d-flex">
                                    <div class="card-product card-product-portrait">
                                        <div class="card-product-badges d-flex">
                                            <div class="card-product-badge">
                                                <svg class="card-product-badge-media" width="39" height="45">
                                                    <use xlink:href="images/sprite.svg#icon-coding"></use>
                                                </svg>
                                            </div>

                                            <div class="card-product-badge">
                                                <svg class="card-product-badge-media" width="45" height="45">
                                                    <use xlink:href="images/sprite.svg#icon-no-keys"></use>
                                                </svg>
                                            </div>
                                        </div>

                                        <a href="product.html" class="card-product-thumbnail">
                                            <img loading="lazy" src="uploads/catalog/product-image-1.jpg" alt="Цилиндр с вертушкой Фабрика замков E AL 60 CP Т01" class="card-product-media">
                                        </a>

                                        <a href="product.html" class="card-product-title">Цилиндр с вертушкой Фабрика замков E AL 60 CP Т01</a>

                                        <div class="card-product-info-list">
                                            <div class="card-product-size-block card-product-info-block d-flex">
                                                <label for="card-product-size-31" class="card-product-info-title card-product-size-title">Типоразмер</label>

                                                <select name="" id="card-product-size-31" class="card-product-size custom-control custom-select" style="width: auto;" >
                                                    <option value="50*60мм">50*60мм</option>
                                                    <option value="60*70мм">60*70мм</option>
                                                </select>
                                            </div>

                                            <div class="card-product-color-block card-product-info-block d-flex">
                                                <label for="" class="card-product-info-title card-product-color-title">Цвет</label>

                                                <div class="card-product-color-list d-flex flex-wrap">
                                                    <div class="card-product-color custom-control custom-color custom-color-sm">
                                                        <input type="radio" class="custom-control-input" id="card-product-color-31-1" name="card-product-color-31" checked >
                                                        <label for="card-product-color-31-1" class="custom-control-label">
                                                            <img loading="lazy" src="uploads/colors/color-brown.png" alt="Коричневый" class="custom-control-image">
                                                        </label>
                                                    </div>

                                                    <div class="card-product-color custom-control custom-color custom-color-sm">
                                                        <input type="radio" class="custom-control-input" id="card-product-color-31-2" name="card-product-color-31" >
                                                        <label for="card-product-color-31-2" class="custom-control-label">
                                                            <img loading="lazy" src="uploads/colors/color-silver.png" alt="Серебряный" class="custom-control-image">
                                                        </label>
                                                    </div>

                                                    <div class="card-product-color custom-control custom-color custom-color-sm">
                                                        <input type="radio" class="custom-control-input" id="card-product-color-31-3" name="card-product-color-31" >
                                                        <label for="card-product-color-31-3" class="custom-control-label">
                                                            <img loading="lazy" src="uploads/colors/color-black.png" alt="Черный" class="custom-control-image">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-product-order-block mt-auto">
                                            <div class="form-row flex-nowrap">
                                                <div class="card-product-price-container col">
                                                    <div class="card-product-price-block d-flex flex-wrap">
                                                        <div class="card-product-price">187<span class="rouble">руб.</span></div>
                                                    </div>
                                                </div>

                                                <div class="card-product-cart-container col-auto">
                                                    <button type="button" class="card-product-cart d-flex align-items-center justify-content-center" data-toggle="modal" data-target="#modalAddToCart" >
                                                        <svg class="card-product-cart-media d-none d-lg-inline" width="16" height="14">
                                                            <use xlink:href="images/sprite.svg#icon-cart"></use>
                                                        </svg>
                                                        Купить
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane fade" id="search-pane-4" role="tabpanel" aria-labelledby="search-tab-4" >
                            <div class="search-products-grid products-grid row">

                                <div class="product-item col-sm-6 col-md-4 col-lg-3 d-flex">
                                    <div class="card-product card-product-portrait">
                                        <div class="card-product-badges d-flex">
                                            <div class="card-product-badge">
                                                <svg class="card-product-badge-media" width="39" height="45">
                                                    <use xlink:href="images/sprite.svg#icon-coding"></use>
                                                </svg>
                                            </div>

                                            <div class="card-product-badge">
                                                <svg class="card-product-badge-media" width="45" height="45">
                                                    <use xlink:href="images/sprite.svg#icon-no-keys"></use>
                                                </svg>
                                            </div>
                                        </div>

                                        <a href="product.html" class="card-product-thumbnail">
                                            <img loading="lazy" src="uploads/catalog/product-image-1.jpg" alt="Цилиндр с вертушкой Фабрика замков E AL 60 CP Т01" class="card-product-media">
                                        </a>

                                        <a href="product.html" class="card-product-title">Цилиндр с вертушкой Фабрика замков E AL 60 CP Т01</a>

                                        <div class="card-product-info-list">
                                            <div class="card-product-size-block card-product-info-block d-flex">
                                                <label for="card-product-size-31" class="card-product-info-title card-product-size-title">Типоразмер</label>

                                                <select name="" id="card-product-size-31" class="card-product-size custom-control custom-select" style="width: auto;" >
                                                    <option value="50*60мм">50*60мм</option>
                                                    <option value="60*70мм">60*70мм</option>
                                                </select>
                                            </div>

                                            <div class="card-product-color-block card-product-info-block d-flex">
                                                <label for="" class="card-product-info-title card-product-color-title">Цвет</label>

                                                <div class="card-product-color-list d-flex flex-wrap">
                                                    <div class="card-product-color custom-control custom-color custom-color-sm">
                                                        <input type="radio" class="custom-control-input" id="card-product-color-31-1" name="card-product-color-31" checked >
                                                        <label for="card-product-color-31-1" class="custom-control-label">
                                                            <img loading="lazy" src="uploads/colors/color-brown.png" alt="Коричневый" class="custom-control-image">
                                                        </label>
                                                    </div>

                                                    <div class="card-product-color custom-control custom-color custom-color-sm">
                                                        <input type="radio" class="custom-control-input" id="card-product-color-31-2" name="card-product-color-31" >
                                                        <label for="card-product-color-31-2" class="custom-control-label">
                                                            <img loading="lazy" src="uploads/colors/color-silver.png" alt="Серебряный" class="custom-control-image">
                                                        </label>
                                                    </div>

                                                    <div class="card-product-color custom-control custom-color custom-color-sm">
                                                        <input type="radio" class="custom-control-input" id="card-product-color-31-3" name="card-product-color-31" >
                                                        <label for="card-product-color-31-3" class="custom-control-label">
                                                            <img loading="lazy" src="uploads/colors/color-black.png" alt="Черный" class="custom-control-image">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-product-order-block mt-auto">
                                            <div class="form-row flex-nowrap">
                                                <div class="card-product-price-container col">
                                                    <div class="card-product-price-block d-flex flex-wrap">
                                                        <div class="card-product-price">187<span class="rouble">руб.</span></div>
                                                    </div>
                                                </div>

                                                <div class="card-product-cart-container col-auto">
                                                    <button type="button" class="card-product-cart d-flex align-items-center justify-content-center" data-toggle="modal" data-target="#modalAddToCart" >
                                                        <svg class="card-product-cart-media d-none d-lg-inline" width="16" height="14">
                                                            <use xlink:href="images/sprite.svg#icon-cart"></use>
                                                        </svg>
                                                        Купить
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane fade" id="search-pane-5" role="tabpanel" aria-labelledby="search-tab-5" >
                            <div class="search-products-grid products-grid row">

                                <div class="product-item col-sm-6 col-md-4 col-lg-3 d-flex">
                                    <div class="card-product card-product-portrait">
                                        <div class="card-product-badges d-flex">
                                            <div class="card-product-badge">
                                                <svg class="card-product-badge-media" width="39" height="45">
                                                    <use xlink:href="images/sprite.svg#icon-coding"></use>
                                                </svg>
                                            </div>

                                            <div class="card-product-badge">
                                                <svg class="card-product-badge-media" width="45" height="45">
                                                    <use xlink:href="images/sprite.svg#icon-no-keys"></use>
                                                </svg>
                                            </div>
                                        </div>

                                        <a href="product.html" class="card-product-thumbnail">
                                            <img loading="lazy" src="uploads/catalog/product-image-1.jpg" alt="Цилиндр с вертушкой Фабрика замков E AL 60 CP Т01" class="card-product-media">
                                        </a>

                                        <a href="product.html" class="card-product-title">Цилиндр с вертушкой Фабрика замков E AL 60 CP Т01</a>

                                        <div class="card-product-info-list">
                                            <div class="card-product-size-block card-product-info-block d-flex">
                                                <label for="card-product-size-31" class="card-product-info-title card-product-size-title">Типоразмер</label>

                                                <select name="" id="card-product-size-31" class="card-product-size custom-control custom-select" style="width: auto;" >
                                                    <option value="50*60мм">50*60мм</option>
                                                    <option value="60*70мм">60*70мм</option>
                                                </select>
                                            </div>

                                            <div class="card-product-color-block card-product-info-block d-flex">
                                                <label for="" class="card-product-info-title card-product-color-title">Цвет</label>

                                                <div class="card-product-color-list d-flex flex-wrap">
                                                    <div class="card-product-color custom-control custom-color custom-color-sm">
                                                        <input type="radio" class="custom-control-input" id="card-product-color-31-1" name="card-product-color-31" checked >
                                                        <label for="card-product-color-31-1" class="custom-control-label">
                                                            <img loading="lazy" src="uploads/colors/color-brown.png" alt="Коричневый" class="custom-control-image">
                                                        </label>
                                                    </div>

                                                    <div class="card-product-color custom-control custom-color custom-color-sm">
                                                        <input type="radio" class="custom-control-input" id="card-product-color-31-2" name="card-product-color-31" >
                                                        <label for="card-product-color-31-2" class="custom-control-label">
                                                            <img loading="lazy" src="uploads/colors/color-silver.png" alt="Серебряный" class="custom-control-image">
                                                        </label>
                                                    </div>

                                                    <div class="card-product-color custom-control custom-color custom-color-sm">
                                                        <input type="radio" class="custom-control-input" id="card-product-color-31-3" name="card-product-color-31" >
                                                        <label for="card-product-color-31-3" class="custom-control-label">
                                                            <img loading="lazy" src="uploads/colors/color-black.png" alt="Черный" class="custom-control-image">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-product-order-block mt-auto">
                                            <div class="form-row flex-nowrap">
                                                <div class="card-product-price-container col">
                                                    <div class="card-product-price-block d-flex flex-wrap">
                                                        <div class="card-product-price">187<span class="rouble">руб.</span></div>
                                                    </div>
                                                </div>

                                                <div class="card-product-cart-container col-auto">
                                                    <button type="button" class="card-product-cart d-flex align-items-center justify-content-center" data-toggle="modal" data-target="#modalAddToCart" >
                                                        <svg class="card-product-cart-media d-none d-lg-inline" width="16" height="14">
                                                            <use xlink:href="images/sprite.svg#icon-cart"></use>
                                                        </svg>
                                                        Купить
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>--}}

                    </div>
                </div>

                {!! $paginator->onEachSide(1)->links('client.shared.pagination.client') !!}

            </div>
        </section>
        @endif

    </main>
@endsection
