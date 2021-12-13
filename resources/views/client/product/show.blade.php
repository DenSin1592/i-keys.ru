@extends('client.layouts.default')

@section('body_class')
    class='product-page d-flex flex-column'
@endsection

@section('content')
    <main class="main-box flex-shrink-0 flex-grow-1">

        <section class="section-product section-gray">
            <section class="section-product-intro">
                <div class="container">
                    <div class="product-intro-grid row">
                        <div class="product-display-container col-12 section-dark" style="background-image: url('/uploads/product/product-display-bg.jpg');" >
                            @include('client.shared.breadcrumbs._breadcrumbs')

                            <div class="product-display">
{{--                                <div class="product-display-category title-h1">Замки Врезные</div>--}}
                                <h1>{{ $metaData['h1'] }}</h1>
                            </div>

                            <div class="product-info-block">
                                <div class="form-row">
                                    <div class="col-auto">
                                        <ul class="product-info-list list-unstyled row">
                                            <li class="product-info-item col-auto" >
                                                <span class="product-info-title">Артикул</span>
                                                <span class="product-info-value font-weight-bold">PD-01-63</span>
                                            </li>

                                            <li class="product-info-item col-auto" >
                                                <span class="product-info-title">Код товара</span>
                                                <span class="product-info-value product-code">20688</span>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="col-auto">
                                        <div class="product-rating-block rating-block d-flex align-items-center">
                                            <div class="rating-list d-flex align-items-center">
                                                <svg class="rating-star-media" width="22" height="22">
                                                    <use xlink:href="/images/sprite.svg#icon-star"></use>
                                                </svg>
                                                <svg class="rating-star-media" width="22" height="22">
                                                    <use xlink:href="/images/sprite.svg#icon-star"></use>
                                                </svg>
                                                <svg class="rating-star-media" width="22" height="22">
                                                    <use xlink:href="/images/sprite.svg#icon-star"></use>
                                                </svg>
                                                <svg class="rating-star-media" width="22" height="22">
                                                    <use xlink:href="/images/sprite.svg#icon-star"></use>
                                                </svg>
                                                <svg class="rating-star-media" width="22" height="22">
                                                    <use xlink:href="/images/sprite.svg#icon-star"></use>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product-thumbnail-container col-12">
                            <div class="swiper-product-gallery swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <a href="uploads/product/product-image-1.jpg" class="product-media-link" data-fancybox="product-media" >
                                            <img loading="lazy" src="uploads/product/product-image-1.jpg" width="275" height="278" alt="Avers PD-01-63" class="product-media">
                                        </a>
                                    </div>

                                    <div class="swiper-slide">
                                        <a href="uploads/product/product-image-1.jpg" class="product-media-link" data-fancybox="product-media" >
                                            <img loading="lazy" src="uploads/product/product-image-1.jpg" width="275" height="278" alt="Avers PD-01-63" class="product-media">
                                        </a>
                                    </div>

                                    <div class="swiper-slide">
                                        <a href="uploads/product/product-image-1.jpg" class="product-media-link" data-fancybox="product-media" >
                                            <img loading="lazy" src="uploads/product/product-image-1.jpg" width="275" height="278" alt="Avers PD-01-63" class="product-media">
                                        </a>
                                    </div>

                                    <div class="swiper-slide">
                                        <a href="uploads/product/product-image-1.jpg" class="product-media-link" data-fancybox="product-media" >
                                            <img loading="lazy" src="uploads/product/product-image-1.jpg" width="275" height="278" alt="Avers PD-01-63" class="product-media">
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col">
                                    <div class="swiper-product-thumbnails swiper-container">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <div class="product-thumbnail">
                                                    <img loading="lazy" src="uploads/product/product-thumbnail-1.jpg" width="47" height="47" alt="Avers PD-01-63" class="product-thumbnail-media">
                                                </div>
                                            </div>

                                            <div class="swiper-slide">
                                                <div class="product-thumbnail">
                                                    <img loading="lazy" src="uploads/product/product-thumbnail-2.jpg" width="47" height="47" alt="Avers PD-01-63" class="product-thumbnail-media">
                                                </div>
                                            </div>

                                            <div class="swiper-slide">
                                                <div class="product-thumbnail">
                                                    <img loading="lazy" src="uploads/product/product-thumbnail-3.jpg" width="47" height="47" alt="Avers PD-01-63" class="product-thumbnail-media">
                                                </div>
                                            </div>

                                            <div class="swiper-slide">
                                                <div class="product-thumbnail">
                                                    <img loading="lazy" src="uploads/product/product-thumbnail-4.jpg" width="47" height="47" alt="Avers PD-01-63" class="product-thumbnail-media">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <a href="https://www.youtube.com/watch?v=-_aWml_EokU&autoplay=1" class="product-presentation-link d-inline-flex flex-column align-items-center" data-fancybox="product-media" >
                                        <img loading="lazy" src="images/icons/icon-youtube.svg" width="42" height="30" alt="" class="product-presentation-media">
                                        Видео о замке
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="product-typography-container col-12 section-dark">
                            <form action="" class="form-product-order">
                                <div class="row">
                                    <div class="product-details-container col-sm-6 col-lg-5">
                                        <div class="product-detail-block d-flex flex-wrap">
                                            <span class="product-detail-title">Цвет</span>

                                            <div class="product-color-list d-flex flex-wrap">
                                                <div class="product-color custom-control custom-color">
                                                    <input type="radio" class="custom-control-input" id="product-color-1" name="product-color" checked="">
                                                    <label for="product-color-1" class="custom-control-label">
                                                        <img loading="lazy" src="uploads/colors/color-brown.png" alt="Коричневый" class="custom-control-image">
                                                    </label>
                                                </div>

                                                <div class="product-color custom-control custom-color">
                                                    <input type="radio" class="custom-control-input" id="product-color-2" name="product-color">
                                                    <label for="product-color-2" class="custom-control-label">
                                                        <img loading="lazy" src="uploads/colors/color-silver.png" alt="Серебряный" class="custom-control-image">
                                                    </label>
                                                </div>

                                                <div class="product-color custom-control custom-color">
                                                    <input type="radio" class="custom-control-input" id="product-color-3" name="product-color">
                                                    <label for="product-color-3" class="custom-control-label">
                                                        <img loading="lazy" src="uploads/colors/color-black.png" alt="Черный" class="custom-control-image">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="product-detail-block d-flex flex-wrap">
                                            <span class="product-detail-title">Типоразмер
                                                <span class="d-none d-xxl-inline text-muted">(Выберите нужный)</span>
                                                <button type="button" class="product-detail-tooltip-toggle tooltip-toggle" data-toggle="tooltip" data-placement="right" title="" data-original-title="Далеко-далеко, за словесными.">?</button>
                                            </span>

                                            <div class="product-scheme-block product-scheme-type-1">
                                                <div class="product-scheme-options-block">
                                                    <div class="row flex-nowrap no-gutters">
                                                        <div class="product-scheme-option-column col-5">
                                                            <div class="product-scheme-option-group">
                                                                <label for="product-scheme-option-1" class="product-scheme-option-title" >Внеш.</label>

                                                                <select name="" id="product-scheme-option-1" class="product-scheme-option-select custom-control custom-select" style="width: 100%;" >
                                                                    <option value="30мм">30мм</option>
                                                                    <option value="40мм">40мм</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="product-scheme-option-column col-7">
                                                            <div class="product-scheme-option-group">
                                                                <label for="product-scheme-option-2" class="product-scheme-option-title" >Внутр.</label>

                                                                <select name="" id="product-scheme-option-2" class="product-scheme-option-select custom-control custom-select" style="width: 100%;" >
                                                                    <option value="75мм">75мм</option>
                                                                    <option value="85мм">85мм</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="product-scheme-thumbnail">
                                                    <img loading="lazy" src="images/scheme/product-scheme-type-1.png" width="262" height="106" alt="" class="product-scheme-media">
                                                </div>
                                            </div>
                                        </div>

                                        <a href="#link" class="product-whatsapp-block d-flex">
                                            <span class="product-whatsapp-thumbnail">
                                                <img loading="lazy" src="images/icons/icon-whatsapp.svg" width="25" height="25" alt="WhatsApp" class="product-whatsapp-media">
                                            </span>

                                            <span class="product-whatsapp-content">
                                                <span class="product-whatsapp-description">Здесь важно не ошибиться, напишите нам в whatsapp, мы поможем</span>
                                            </span>
                                        </a>
                                    </div>

                                    <div class="product-order-container col-sm-6 col-lg-7">
                                        <div class="product-order-block">
                                            <div class="product-status-block">
                                                <span class="product-status product-available d-inline-block">
                                                    <svg class="product-status-media" width="14" height="10">
                                                        <use xlink:href="/images/sprite.svg#icon-check"></use>
                                                    </svg>
                                                    В наличии
                                                </span>
                                            </div>

                                            <span class="product-price">187<span class="rouble"></span></span>
                                            <span class="product-old-price text-muted">499<span class="rouble"></span></span>
                                            <span class="product-sale-price font-weight-bold text-danger" >Экономия 13%</span>
                                            <span class="product-sale-hint d-block" >Распродажа в связи с обновлением ассортимента</span>
                                        </div>

                                        <div class="product-controls-block">
                                            <div class="form-row">
                                                <div class="col">
                                                    <button type="button" class="product-control product-control-cart btn btn-lg" data-toggle="modal" data-target="#modalAddToCart" >
                                                        <svg class="product-control-media" width="28" height="25">
                                                            <use xlink:href="/images/sprite.svg#icon-cart"></use>
                                                        </svg>

                                                        <span class="product-control-text" >Купить</span>
                                                    </button>
                                                </div>

                                                <div class="col-auto">
                                                    <button type="button" class="product-control product-control-compare btn btn-lg btn-secondary font-weight-normal" data-toggle="modal" data-target="#modalAddToCompare" >
                                                        <svg class="product-control-media" width="24" height="25">
                                                            <use xlink:href="/images/sprite.svg#icon-compare"></use>
                                                        </svg>

                                                        <span class="product-control-text d-none d-lg-inline" >Сравнить</span>
                                                    </button>
                                                </div>

                                                <div class="col-12">
                                                    <div class="product-controls-hint text-danger" >
                                                        <span class="product-controls-hint-media">!</span>
                                                        Только по предоплате
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="product-included-block">
                                            <svg class="product-included-media" width="20" height="20">
                                                <use xlink:href="/images/sprite.svg#icon-key"></use>
                                            </svg>

                                            <span class="product-included-title">В комплекте <b>3</b> ключа</span>

                                            <button type="button" class="product-included-toggle" data-toggle="modal" data-target="#modalKeysQuantity" >Добавить еще ключи на всю семью</button>
                                        </div>

                                        <div class="product-delivery-block d-flex align-items-center">
                                            <img src="images/icons/icon-delivery-light.png" class="product-delivery-media" width="40" height="20" alt="">
                                            <!-- <span class="product-delivery-thumbnail">
                                                <svg class="product-delivery-media" width="40" height="20">
                                                    <use xlink:href="/images/sprite.svg#icon-delivery"></use>
                                                </svg>
                                            </span> -->

                                            <span class="product-delivery-content">
                                                Доставка по <button type="button" class="product-delivery-toggle" data-toggle="modal" data-target="#modalLocation" >Москве</button> <br class="d-lg-none" > <b>1-2 дня от 450 руб</b>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-product-attributes">
                <div class="container">
                    <div class="product-attributes-headline">Основные характеристики</div>

                    <div class="product-attributes-grid row">
                        <div class="product-attribute-item col-sm-6 col-md-4 col-xl-2">
                            <div class="product-attribute-thumbnail">
                                <img src="images/filter/filter-configuration-icon-1.png" width="83" height="20" alt="" class="product-attribute-media">
                            </div>
                            <div class="product-attribute-title">Тип открывания цилиндрового механизма</div>
                            <div class="product-attribute-description">Ключ-ключ</div>
                        </div>

                        <div class="product-attribute-item col-sm-6 col-md-4 col-xl-2">
                            <div class="product-attribute-title">Серия</div>
                            <div class="product-attribute-description">Asix</div>
                            <a href="#link" class="product-attribute-link text-muted">Посмотреть аналогичные серии других производителей от … руб</a>
                        </div>

                        <div class="product-attribute-item col-sm-6 col-md-4 col-xl-2">
                            <div class="product-attribute-title">Производитель</div>
                            <div class="product-attribute-description">Avers</div>
                            <a href="#link" class="product-attribute-link text-muted">Посмотреть сравнение производителей и серий</a>
                        </div>

                        <div class="product-attribute-item col-sm-6 col-md-4 col-xl-2">
                            <div class="product-attribute-thumbnail">
                                <svg class="product-attribute-media" width="22" height="30">
                                    <use xlink:href="/images/sprite.svg#icon-security"></use>
                                </svg>
                                <svg class="product-attribute-media" width="22" height="30">
                                    <use xlink:href="/images/sprite.svg#icon-security"></use>
                                </svg>
                                <svg class="product-attribute-media" width="22" height="30">
                                    <use xlink:href="/images/sprite.svg#icon-security"></use>
                                </svg>
                                <svg class="product-attribute-media" width="22" height="30">
                                    <use xlink:href="/images/sprite.svg#icon-security"></use>
                                </svg>
                                <svg class="product-attribute-media disable" width="22" height="30">
                                    <use xlink:href="/images/sprite.svg#icon-security"></use>
                                </svg>
                            </div>

                            <div class="product-attribute-title">Класс безопасности</div>

                            <div class="product-attribute-description">Для помещений, в которых хранится ценностей более 20 млн. руб</div>
                        </div>

                        <div class="product-attribute-item col-sm-6 col-md-4 col-xl-2">
                            <div class="product-attribute-thumbnail">
                                <svg class="product-attribute-media" width="29" height="29">
                                    <use xlink:href="/images/sprite.svg#icon-key"></use>
                                </svg>
                                <svg class="product-attribute-media" width="29" height="29">
                                    <use xlink:href="/images/sprite.svg#icon-key"></use>
                                </svg>
                                <svg class="product-attribute-media" width="29" height="29">
                                    <use xlink:href="/images/sprite.svg#icon-key"></use>
                                </svg>
                            </div>

                            <div class="product-attribute-title">Количество ключей</div>

                            <div class="product-attribute-description">3</div>

                            <a href="#link" class="product-attribute-link text-muted">Вам недостаточно такого количества? Закажите сейчас со скидкой</a>
                        </div>

                        <div class="product-attribute-item col-sm-6 col-md-4 col-xl-2">
                            <div class="product-attribute-thumbnail product-attribute-lead-thumbnail text-success">
                                <svg class="product-attribute-media" width="32" height="30">
                                    <use xlink:href="/images/sprite.svg#icon-catalog-master"></use>
                                </svg>
                            </div>

                            <div class="product-attribute-title product-attribute-lead-title text-success">Хотите открывать все двери одним ключом?</div>

                            <a href="#link" class="product-attribute-link product-attribute-lead-link">Расскажем как!</a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-product-expert">
                <div class="container-fluid px-0">
                    <div class="product-expert-grid row no-gutters">
                        <div class="product-expert-item col-lg-4">
                            <a href="#link" class="card-expert d-flex align-items-center justify-content-center">
                                <span class="card-expert-thumbnail">
                                    <img loading="lazy" src="uploads/expert/expert-media-1.jpg" alt="Как снять цилиндр?" class="card-expert-media">
                                </span>

                                <span class="card-expert-typography">
                                    <span class="card-expert-title">Как снять цилиндр?</span>
                                </span>
                            </a>
                        </div>

                        <div class="product-expert-item col-lg-4">
                            <a href="#link" class="card-expert d-flex align-items-center justify-content-center">
                                <span class="card-expert-thumbnail">
                                    <img loading="lazy" src="uploads/expert/expert-media-2.jpg" alt="Как измерить цилиндр?" class="card-expert-media">
                                </span>

                                <span class="card-expert-typography">
                                    <span class="card-expert-title">Как измерить цилиндр?</span>
                                </span>
                            </a>
                        </div>

                        <div class="product-expert-item col-lg-4">
                            <a href="#link" class="card-expert d-flex align-items-center justify-content-center">
                                <span class="card-expert-thumbnail">
                                    <img loading="lazy" src="uploads/expert/expert-media-3.jpg" alt="3 фото, которые нужны для определения модели замка" class="card-expert-media">
                                </span>

                                <span class="card-expert-typography">
                                    <span class="card-expert-title">3 фото, которые нужны для определения модели замка</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-product-specifications">
                <div class="container">
                    <div class="section-header">
                        <div class="section-title title-h3 font-family-secondary">Параметры замка</div>
                    </div>

                    <div class="row">
                        <div class="product-specifications-container col-xxl-8">
                            <div class="product-specifications-grid row">
                                <div class="product-specifications-column col-md-6">
                                    <div class="product-specifications-block">
                                        <div class="product-specifications-headline">Общие</div>

                                        <ul class="product-specifications-list list-unstyled">
                                            <li class="product-specifications-item row">
                                                <span class="product-specifications-title col-sm-6">Контроль изготовления копий </span>
                                                <span class="product-specifications-text col-sm-6">Защищен от копирования</span>
                                            </li>

                                            <li class="product-specifications-item row">
                                                <span class="product-specifications-title col-sm-6">Перекодировка</span>
                                                <span class="product-specifications-text col-sm-6">Возможна</span>
                                            </li>

                                            <li class="product-specifications-item row">
                                                <span class="product-specifications-title col-sm-6">Размер</span>
                                                <span class="product-specifications-text col-sm-6">90х60х90</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="product-specifications-column col-md-6">
                                    <div class="product-specifications-block">
                                        <div class="product-specifications-headline">Технические</div>

                                        <ul class="product-specifications-list list-unstyled">
                                            <li class="product-specifications-item row">
                                                <span class="product-specifications-title col-sm-6">Материал</span>
                                                <span class="product-specifications-text col-sm-6">Защищен от копирования</span>
                                            </li>

                                            <li class="product-specifications-item row">
                                                <span class="product-specifications-title col-sm-6">Тип механизма секретности</span>
                                                <span class="product-specifications-text col-sm-6">Цилиндровый</span>
                                            </li>

                                            <li class="product-specifications-item row">
                                                <span class="product-specifications-title col-sm-6">Уровень взломостойкости</span>
                                                <span class="product-specifications-text col-sm-6">Высокий</span>
                                            </li>

                                            <li class="product-specifications-item row">
                                                <span class="product-specifications-title col-sm-6">Автоматическое запирание</span>
                                                <span class="product-specifications-text col-sm-6">Автоматическое</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="product-specifications-column col-md-6">
                                    <div class="product-specifications-block">
                                        <div class="product-specifications-headline">Параметры ключа</div>

                                        <ul class="product-specifications-list list-unstyled">
                                            <li class="product-specifications-item row">
                                                <span class="product-specifications-title col-sm-6">Количество ключей</span>
                                                <span class="product-specifications-text col-sm-6">3</span>
                                            </li>

                                            <li class="product-specifications-item row">
                                                <span class="product-specifications-title col-sm-6">Тип ключа</span>
                                                <span class="product-specifications-text col-sm-6">Односторонний ключ</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="product-documents-container col-xxl-3 offset-xxl-1">
                            <div class="product-documents-block">
                                <div class="product-documents-headline">Файлы для скачивания</div>

                                <ul class="product-documents-list list-unstyled row">
                                    <li class="product-documents-item col-md-4 col-xxl-12">
                                        <a href="#link" class="card-document d-inline-flex align-items-center">
                                            <span class="card-document-thumbnail">
                                                <svg class="card-document-media" width="44" height="44">
                                                    <use xlink:href="/images/sprite.svg#icon-pdf"></use>
                                                </svg>
                                            </span>

                                            <span class="card-document-typogpraphy">
                                                <span class="card-document-title">Инструкция</span>
                                                <span class="card-document-size text-muted">12 мб</span>
                                            </span>
                                        </a>
                                    </li>

                                    <li class="product-documents-item col-md-4 col-xxl-12">
                                        <a href="#link" class="card-document d-inline-flex align-items-center">
                                            <span class="card-document-thumbnail">
                                                <svg class="card-document-media" width="44" height="44">
                                                    <use xlink:href="/images/sprite.svg#icon-pdf"></use>
                                                </svg>
                                            </span>

                                            <span class="card-document-typogpraphy">
                                                <span class="card-document-title">Сертификат</span>
                                                <span class="card-document-size text-muted">2 мб</span>
                                            </span>
                                        </a>
                                    </li>

                                    <li class="product-documents-item col-md-4 col-xxl-12">
                                        <a href="#link" class="card-document d-inline-flex align-items-center">
                                            <span class="card-document-thumbnail">
                                                <svg class="card-document-media" width="44" height="44">
                                                    <use xlink:href="/images/sprite.svg#icon-pdf"></use>
                                                </svg>
                                            </span>

                                            <span class="card-document-typogpraphy">
                                                <span class="card-document-title">Паспорт</span>
                                                <span class="card-document-size text-muted">1,6 мб</span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-products section-related-products">
                <div class="container">
                    <div class="section-header">
                        <div class="section-title title-h3 font-family-secondary">Замки для этого цилиндра</div>
                        <div class="section-alert text-danger"><span class="section-alert-media">!</span> Мы рекомендуем покупать замок и комплектующие одного производителя</div>
                    </div>

                    <div class="row">
                        <div class="col-lg-9 d-flex">
                            <div class="swiper-products swiper-related-products swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide col-auto col-sm-6 col-md-4 col-lg-4 d-flex">
                                        <div class="card-product card-product-portrait">
                                            <div class="card-product-badges d-flex">
                                                <div class="card-product-badge">
                                                    <svg class="card-product-badge-media" width="39" height="45">
                                                        <use xlink:href="/images/sprite.svg#icon-coding"></use>
                                                    </svg>
                                                </div>

                                                <div class="card-product-badge">
                                                    <svg class="card-product-badge-media" width="45" height="45">
                                                        <use xlink:href="/images/sprite.svg#icon-no-keys"></use>
                                                    </svg>
                                                </div>
                                            </div>

                                            <div class="card-product-thumbnail">
                                                <img loading="lazy" src="uploads/catalog/product-image-1.jpg" alt="Цилиндр с вертушкой Фабрика замков E AL 60 CP Т01" class="card-product-media">
                                            </div>

                                            <a href="#link" class="card-product-title">Цилиндр с вертушкой Фабрика замков E AL 60 CP Т01</a>

                                            <div class="card-product-info-list">
                                                <div class="card-product-color-block card-product-info-block d-flex">
                                                    <label for="" class="card-product-info-title card-product-color-title">Цвет</label>

                                                    <div class="card-product-color-list d-flex flex-wrap">
                                                        <div class="card-product-color custom-control custom-color custom-color-sm">
                                                            <input type="radio" class="custom-control-input" id="card-product-color-1-1" name="card-product-color-1" checked >
                                                            <label for="card-product-color-1-1" class="custom-control-label">
                                                                <img loading="lazy" src="uploads/colors/color-brown.png" alt="Коричневый" class="custom-control-image">
                                                            </label>
                                                        </div>

                                                        <div class="card-product-color custom-control custom-color custom-color-sm">
                                                            <input type="radio" class="custom-control-input" id="card-product-color-1-2" name="card-product-color-1" >
                                                            <label for="card-product-color-1-2" class="custom-control-label">
                                                                <img loading="lazy" src="uploads/colors/color-silver.png" alt="Серебряный" class="custom-control-image">
                                                            </label>
                                                        </div>

                                                        <div class="card-product-color custom-control custom-color custom-color-sm">
                                                            <input type="radio" class="custom-control-input" id="card-product-color-1-3" name="card-product-color-1" >
                                                            <label for="card-product-color-1-3" class="custom-control-label">
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
                                                            <div class="card-product-price">187<span class="rouble" ></span></div>
                                                        </div>
                                                    </div>

                                                    <div class="card-product-cart-container col-auto">
                                                        <button type="button" class="card-product-cart d-flex align-items-center justify-content-center" data-toggle="modal" data-target="#modalAddToCart" >
                                                            <svg class="card-product-cart-media d-none d-lg-inline" width="16" height="14">
                                                                <use xlink:href="/images/sprite.svg#icon-cart"></use>
                                                            </svg>
                                                            Купить
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="swiper-slide col-auto col-sm-6 col-md-4 col-lg-4 d-flex">
                                        <div class="card-product card-product-portrait">
                                            <div class="card-product-badges d-flex">
                                                <div class="card-product-badge">
                                                    <svg class="card-product-badge-media" width="39" height="45">
                                                        <use xlink:href="/images/sprite.svg#icon-coding"></use>
                                                    </svg>
                                                </div>

                                                <div class="card-product-badge">
                                                    <svg class="card-product-badge-media" width="45" height="45">
                                                        <use xlink:href="/images/sprite.svg#icon-no-keys"></use>
                                                    </svg>
                                                </div>
                                            </div>

                                            <div class="card-product-thumbnail">
                                                <img loading="lazy" src="uploads/catalog/product-image-2.jpg" alt="Цилиндр с вертушкой Фабрика замков E AL 60 CP Т01" class="card-product-media">
                                            </div>

                                            <a href="#link" class="card-product-title">Цилиндр с вертушкой Фабрика замков E AL 60 CP Т01</a>

                                            <div class="card-product-info-list">
                                                <div class="card-product-color-block card-product-info-block d-flex">
                                                    <label for="" class="card-product-info-title card-product-color-title">Цвет</label>

                                                    <div class="card-product-color-list d-flex flex-wrap">
                                                        <div class="card-product-color custom-control custom-color custom-color-sm">
                                                            <input type="radio" class="custom-control-input" id="card-product-color-2-1" name="card-product-color-2" checked >
                                                            <label for="card-product-color-2-1" class="custom-control-label">
                                                                <img loading="lazy" src="uploads/colors/color-brown.png" alt="Коричневый" class="custom-control-image">
                                                            </label>
                                                        </div>

                                                        <div class="card-product-color custom-control custom-color custom-color-sm">
                                                            <input type="radio" class="custom-control-input" id="card-product-color-2-2" name="card-product-color-2" >
                                                            <label for="card-product-color-2-2" class="custom-control-label">
                                                                <img loading="lazy" src="uploads/colors/color-silver.png" alt="Серебряный" class="custom-control-image">
                                                            </label>
                                                        </div>

                                                        <div class="card-product-color custom-control custom-color custom-color-sm">
                                                            <input type="radio" class="custom-control-input" id="card-product-color-2-3" name="card-product-color-2" >
                                                            <label for="card-product-color-2-3" class="custom-control-label">
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
                                                            <div class="card-product-price">187<span class="rouble" ></span></div>
                                                        </div>
                                                    </div>

                                                    <div class="card-product-cart-container col-auto">
                                                        <button type="button" class="card-product-cart d-flex align-items-center justify-content-center" data-toggle="modal" data-target="#modalAddToCart" >
                                                            <svg class="card-product-cart-media d-none d-lg-inline" width="16" height="14">
                                                                <use xlink:href="/images/sprite.svg#icon-cart"></use>
                                                            </svg>
                                                            Купить
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="swiper-slide col-auto col-sm-6 col-md-4 col-lg-4 d-flex">
                                        <div class="card-product card-product-portrait">
                                            <div class="card-product-badges d-flex">
                                                <div class="card-product-badge">
                                                    <svg class="card-product-badge-media" width="45" height="45">
                                                        <use xlink:href="/images/sprite.svg#icon-sale"></use>
                                                    </svg>
                                                </div>

                                                <div class="card-product-badge">
                                                    <svg class="card-product-badge-media" width="39" height="45">
                                                        <use xlink:href="/images/sprite.svg#icon-coding"></use>
                                                    </svg>
                                                </div>

                                                <div class="card-product-badge">
                                                    <svg class="card-product-badge-media" width="45" height="45">
                                                        <use xlink:href="/images/sprite.svg#icon-no-keys"></use>
                                                    </svg>
                                                </div>
                                            </div>

                                            <div class="card-product-thumbnail">
                                                <img loading="lazy" src="uploads/catalog/product-image-3.jpg" alt="Цилиндр с вертушкой Фабрика замков E AL 60 CP Т01" class="card-product-media">
                                            </div>

                                            <a href="#link" class="card-product-title">Цилиндр с вертушкой Фабрика замков E AL 60 CP Т01</a>

                                            <div class="card-product-info-list">
                                                <div class="card-product-color-block card-product-info-block d-flex">
                                                    <label for="" class="card-product-info-title card-product-color-title">Цвет</label>

                                                    <div class="card-product-color-list d-flex flex-wrap">
                                                        <div class="card-product-color custom-control custom-color custom-color-sm">
                                                            <input type="radio" class="custom-control-input" id="card-product-color-3-1" name="card-product-color-3" checked >
                                                            <label for="card-product-color-3-1" class="custom-control-label">
                                                                <img loading="lazy" src="uploads/colors/color-brown.png" alt="Коричневый" class="custom-control-image">
                                                            </label>
                                                        </div>

                                                        <div class="card-product-color custom-control custom-color custom-color-sm">
                                                            <input type="radio" class="custom-control-input" id="card-product-color-3-2" name="card-product-color-3" >
                                                            <label for="card-product-color-3-2" class="custom-control-label">
                                                                <img loading="lazy" src="uploads/colors/color-silver.png" alt="Серебряный" class="custom-control-image">
                                                            </label>
                                                        </div>

                                                        <div class="card-product-color custom-control custom-color custom-color-sm">
                                                            <input type="radio" class="custom-control-input" id="card-product-color-3-3" name="card-product-color-3" >
                                                            <label for="card-product-color-3-3" class="custom-control-label">
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
                                                            <div class="card-product-price">187<span class="rouble" ></span></div>
                                                            <div class="card-product-old-price">499<span class="rouble" ></span></div>
                                                        </div>

                                                        <div class="card-product-sale-price text-danger">Экономия 13%</div>
                                                    </div>

                                                    <div class="card-product-cart-container col-auto">
                                                        <button type="button" class="card-product-cart d-flex align-items-center justify-content-center" data-toggle="modal" data-target="#modalAddToCart" >
                                                            <svg class="card-product-cart-media d-none d-lg-inline" width="16" height="14">
                                                                <use xlink:href="/images/sprite.svg#icon-cart"></use>
                                                            </svg>
                                                            Купить
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="swiper-slide col-auto col-sm-6 col-md-4 col-lg-4 d-flex">
                                        <div class="card-product card-product-portrait">
                                            <div class="card-product-badges d-flex">
                                                <div class="card-product-badge">
                                                    <svg class="card-product-badge-media" width="45" height="45">
                                                        <use xlink:href="/images/sprite.svg#icon-sale"></use>
                                                    </svg>
                                                </div>

                                                <div class="card-product-badge">
                                                    <svg class="card-product-badge-media" width="39" height="45">
                                                        <use xlink:href="/images/sprite.svg#icon-coding"></use>
                                                    </svg>
                                                </div>

                                                <div class="card-product-badge">
                                                    <svg class="card-product-badge-media" width="45" height="45">
                                                        <use xlink:href="/images/sprite.svg#icon-no-keys"></use>
                                                    </svg>
                                                </div>
                                            </div>

                                            <div class="card-product-thumbnail">
                                                <img loading="lazy" src="uploads/catalog/product-image-3.jpg" alt="Цилиндр с вертушкой Фабрика замков E AL 60 CP Т01" class="card-product-media">
                                            </div>

                                            <a href="#link" class="card-product-title">Цилиндр с вертушкой Фабрика замков E AL 60 CP Т01</a>

                                            <div class="card-product-info-list">
                                                <div class="card-product-color-block card-product-info-block d-flex">
                                                    <label for="" class="card-product-info-title card-product-color-title">Цвет</label>

                                                    <div class="card-product-color-list d-flex flex-wrap">
                                                        <div class="card-product-color custom-control custom-color custom-color-sm">
                                                            <input type="radio" class="custom-control-input" id="card-product-color-4-1" name="card-product-color-4" checked >
                                                            <label for="card-product-color-4-1" class="custom-control-label">
                                                                <img loading="lazy" src="uploads/colors/color-brown.png" alt="Коричневый" class="custom-control-image">
                                                            </label>
                                                        </div>

                                                        <div class="card-product-color custom-control custom-color custom-color-sm">
                                                            <input type="radio" class="custom-control-input" id="card-product-color-4-2" name="card-product-color-4" >
                                                            <label for="card-product-color-4-2" class="custom-control-label">
                                                                <img loading="lazy" src="uploads/colors/color-silver.png" alt="Серебряный" class="custom-control-image">
                                                            </label>
                                                        </div>

                                                        <div class="card-product-color custom-control custom-color custom-color-sm">
                                                            <input type="radio" class="custom-control-input" id="card-product-color-4-3" name="card-product-color-4" >
                                                            <label for="card-product-color-4-3" class="custom-control-label">
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
                                                            <div class="card-product-price">187<span class="rouble" ></span></div>
                                                            <div class="card-product-old-price">499<span class="rouble" ></span></div>
                                                        </div>

                                                        <div class="card-product-sale-price text-danger">Экономия 13%</div>
                                                    </div>

                                                    <div class="card-product-cart-container col-auto">
                                                        <button type="button" class="card-product-cart d-flex align-items-center justify-content-center" data-toggle="modal" data-target="#modalAddToCart" >
                                                            <svg class="card-product-cart-media d-none d-lg-inline" width="16" height="14">
                                                                <use xlink:href="/images/sprite.svg#icon-cart"></use>
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
                        </div>

                        <div class="col-lg-3 d-flex">
                            <a href="catalog.html" class="card-banner card-banner-catalog d-flex flex-column justify-content-center">
                                <span class="row align-items-center justify-content-center">
                                    <span class="card-banner-thumbnail-container col-auto col-lg-12">
                                        <span class="card-banner-thumbnail">
                                            <svg class="card-banner-media" width="40" height="40">
                                                <use xlink:href="/images/sprite.svg#icon-catalog"></use>
                                            </svg>
                                        </span>
                                    </span>

                                    <span class="card-banner-typography-container col col-sm-auto col-lg-12">
                                        <span class="card-banner-title">Посмотреть все замки</span>
                                    </span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-product-services section-services-related">
                <div class="container">
                    <div class="section-header">
                        <div class="row justify-content-between">
                            <div class="col">
                                <div class="section-title title-h3">Услуги</div>
                            </div>

                            <div class="col-auto">
                                <a href="services.html" class="section-cta">Все услуги</a>
                            </div>
                        </div>
                    </div>

                    <div class="services-related-grid row">
                        <div class="service-related-item col-lg-4">
                            <div class="card card-service-related">
                                <div class="row flex-nowrap">
                                    <div class="card-thumbnail col-auto">
                                        <img loading="lazy" src="uploads/services/service-related-thumbnail-item-1.jpg" width="100" height="100" alt="Заедает замок? Отремонтируем!" class="card-media">
                                    </div>

                                    <div class="card-content col align-self-center">
                                        <a href="#link" class="card-title title-h4" >Заедает замок? <br> Отремонтируем!</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="service-related-item col-lg-4">
                            <div class="card card-service-related">
                                <div class="row flex-nowrap">
                                    <div class="card-thumbnail col-auto">
                                        <img loading="lazy" src="uploads/services/service-related-thumbnail-item-2.jpg" width="100" height="100" alt="Сломался замок? Вскроем дверь и заменим замок!" class="card-media">
                                    </div>

                                    <div class="card-content col align-self-center">
                                        <a href="#link" class="card-title title-h4" >Сломался замок? <br> Вскроем дверь и заменим замок!</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="service-related-item col-lg-4">
                            <div class="card card-service-related">
                                <div class="row flex-nowrap">
                                    <div class="card-thumbnail col-auto">
                                        <img loading="lazy" src="uploads/services/service-related-thumbnail-item-3.jpg" width="100" height="100" alt="Потеряли ключ? Перекодируем замок!" class="card-media">
                                    </div>

                                    <div class="card-content col align-self-center">
                                        <a href="#link" class="card-title title-h4" >Потеряли ключ? <br> Перекодируем замок!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-products section-related-products">
                <div class="container">
                    <div class="section-header">
                        <div class="section-title title-h3 font-family-secondary">Хотите повысить взломостойкость, купите броненакладку</div>
                    </div>

                    <div class="row">
                        <div class="col-lg-9 d-flex">
                            <div class="swiper-products swiper-related-products swiper-container">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide col-auto col-sm-6 col-md-4 col-lg-4 d-flex">
                                        <div class="card-product card-product-portrait">
                                            <div class="card-product-badges d-flex">
                                                <div class="card-product-badge">
                                                    <svg class="card-product-badge-media" width="39" height="45">
                                                        <use xlink:href="/images/sprite.svg#icon-coding"></use>
                                                    </svg>
                                                </div>

                                                <div class="card-product-badge">
                                                    <svg class="card-product-badge-media" width="45" height="45">
                                                        <use xlink:href="/images/sprite.svg#icon-no-keys"></use>
                                                    </svg>
                                                </div>
                                            </div>

                                            <div class="card-product-thumbnail">
                                                <img loading="lazy" src="uploads/catalog/product-image-4.jpg" alt="Броненакладка DEF 4825" class="card-product-media">
                                            </div>

                                            <a href="#link" class="card-product-title">Броненакладка DEF 4825</a>

                                            <div class="card-product-info-list">
                                                <div class="card-product-color-block card-product-info-block d-flex">
                                                    <label for="" class="card-product-info-title card-product-color-title">Цвет</label>

                                                    <div class="card-product-color-list d-flex flex-wrap">
                                                        <div class="card-product-color custom-control custom-color custom-color-sm">
                                                            <input type="radio" class="custom-control-input" id="card-product-color-1-1" name="card-product-color-1" checked >
                                                            <label for="card-product-color-1-1" class="custom-control-label">
                                                                <img loading="lazy" src="uploads/colors/color-brown.png" alt="Коричневый" class="custom-control-image">
                                                            </label>
                                                        </div>

                                                        <div class="card-product-color custom-control custom-color custom-color-sm">
                                                            <input type="radio" class="custom-control-input" id="card-product-color-1-2" name="card-product-color-1" >
                                                            <label for="card-product-color-1-2" class="custom-control-label">
                                                                <img loading="lazy" src="uploads/colors/color-silver.png" alt="Серебряный" class="custom-control-image">
                                                            </label>
                                                        </div>

                                                        <div class="card-product-color custom-control custom-color custom-color-sm">
                                                            <input type="radio" class="custom-control-input" id="card-product-color-1-3" name="card-product-color-1" >
                                                            <label for="card-product-color-1-3" class="custom-control-label">
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
                                                            <div class="card-product-price">187<span class="rouble" ></span></div>
                                                        </div>
                                                    </div>

                                                    <div class="card-product-cart-container col-auto">
                                                        <button type="button" class="card-product-cart d-flex align-items-center justify-content-center" data-toggle="modal" data-target="#modalAddToCart" >
                                                            <svg class="card-product-cart-media d-none d-lg-inline" width="16" height="14">
                                                                <use xlink:href="/images/sprite.svg#icon-cart"></use>
                                                            </svg>
                                                            Купить
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="swiper-slide col-auto col-sm-6 col-md-4 col-lg-4 d-flex">
                                        <div class="card-product card-product-portrait">
                                            <div class="card-product-badges d-flex">
                                                <div class="card-product-badge">
                                                    <svg class="card-product-badge-media" width="39" height="45">
                                                        <use xlink:href="/images/sprite.svg#icon-coding"></use>
                                                    </svg>
                                                </div>

                                                <div class="card-product-badge">
                                                    <svg class="card-product-badge-media" width="45" height="45">
                                                        <use xlink:href="/images/sprite.svg#icon-no-keys"></use>
                                                    </svg>
                                                </div>
                                            </div>

                                            <div class="card-product-thumbnail">
                                                <img loading="lazy" src="uploads/catalog/product-image-5.jpg" alt="Броненакладка DEF 5513" class="card-product-media">
                                            </div>

                                            <a href="#link" class="card-product-title">Броненакладка DEF 5513</a>

                                            <div class="card-product-info-list">
                                                <div class="card-product-color-block card-product-info-block d-flex">
                                                    <label for="" class="card-product-info-title card-product-color-title">Цвет</label>

                                                    <div class="card-product-color-list d-flex flex-wrap">
                                                        <div class="card-product-color custom-control custom-color custom-color-sm">
                                                            <input type="radio" class="custom-control-input" id="card-product-color-2-1" name="card-product-color-2" checked >
                                                            <label for="card-product-color-2-1" class="custom-control-label">
                                                                <img loading="lazy" src="uploads/colors/color-brown.png" alt="Коричневый" class="custom-control-image">
                                                            </label>
                                                        </div>

                                                        <div class="card-product-color custom-control custom-color custom-color-sm">
                                                            <input type="radio" class="custom-control-input" id="card-product-color-2-2" name="card-product-color-2" >
                                                            <label for="card-product-color-2-2" class="custom-control-label">
                                                                <img loading="lazy" src="uploads/colors/color-silver.png" alt="Серебряный" class="custom-control-image">
                                                            </label>
                                                        </div>

                                                        <div class="card-product-color custom-control custom-color custom-color-sm">
                                                            <input type="radio" class="custom-control-input" id="card-product-color-2-3" name="card-product-color-2" >
                                                            <label for="card-product-color-2-3" class="custom-control-label">
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
                                                            <div class="card-product-price">187<span class="rouble" ></span></div>
                                                        </div>
                                                    </div>

                                                    <div class="card-product-cart-container col-auto">
                                                        <button type="button" class="card-product-cart d-flex align-items-center justify-content-center" data-toggle="modal" data-target="#modalAddToCart" >
                                                            <svg class="card-product-cart-media d-none d-lg-inline" width="16" height="14">
                                                                <use xlink:href="/images/sprite.svg#icon-cart"></use>
                                                            </svg>
                                                            Купить
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="swiper-slide col-auto col-sm-6 col-md-4 col-lg-4 d-flex">
                                        <div class="card-product card-product-portrait">
                                            <div class="card-product-badges d-flex">
                                                <div class="card-product-badge">
                                                    <svg class="card-product-badge-media" width="45" height="45">
                                                        <use xlink:href="/images/sprite.svg#icon-sale"></use>
                                                    </svg>
                                                </div>

                                                <div class="card-product-badge">
                                                    <svg class="card-product-badge-media" width="39" height="45">
                                                        <use xlink:href="/images/sprite.svg#icon-coding"></use>
                                                    </svg>
                                                </div>

                                                <div class="card-product-badge">
                                                    <svg class="card-product-badge-media" width="45" height="45">
                                                        <use xlink:href="/images/sprite.svg#icon-no-keys"></use>
                                                    </svg>
                                                </div>
                                            </div>

                                            <div class="card-product-thumbnail">
                                                <img loading="lazy" src="uploads/catalog/product-image-6.jpg" alt="Броненакладка Fuaro DEF 9726" class="card-product-media">
                                            </div>

                                            <a href="#link" class="card-product-title">Броненакладка Fuaro DEF 9726</a>

                                            <div class="card-product-info-list">
                                                <div class="card-product-color-block card-product-info-block d-flex">
                                                    <label for="" class="card-product-info-title card-product-color-title">Цвет</label>

                                                    <div class="card-product-color-list d-flex flex-wrap">
                                                        <div class="card-product-color custom-control custom-color custom-color-sm">
                                                            <input type="radio" class="custom-control-input" id="card-product-color-3-1" name="card-product-color-3" checked >
                                                            <label for="card-product-color-3-1" class="custom-control-label">
                                                                <img loading="lazy" src="uploads/colors/color-brown.png" alt="Коричневый" class="custom-control-image">
                                                            </label>
                                                        </div>

                                                        <div class="card-product-color custom-control custom-color custom-color-sm">
                                                            <input type="radio" class="custom-control-input" id="card-product-color-3-2" name="card-product-color-3" >
                                                            <label for="card-product-color-3-2" class="custom-control-label">
                                                                <img loading="lazy" src="uploads/colors/color-silver.png" alt="Серебряный" class="custom-control-image">
                                                            </label>
                                                        </div>

                                                        <div class="card-product-color custom-control custom-color custom-color-sm">
                                                            <input type="radio" class="custom-control-input" id="card-product-color-3-3" name="card-product-color-3" >
                                                            <label for="card-product-color-3-3" class="custom-control-label">
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
                                                            <div class="card-product-price">187<span class="rouble" ></span></div>
                                                            <div class="card-product-old-price">499<span class="rouble" ></span></div>
                                                        </div>

                                                        <div class="card-product-sale-price text-danger">Экономия 13%</div>
                                                    </div>

                                                    <div class="card-product-cart-container col-auto">
                                                        <button type="button" class="card-product-cart d-flex align-items-center justify-content-center" data-toggle="modal" data-target="#modalAddToCart" >
                                                            <svg class="card-product-cart-media d-none d-lg-inline" width="16" height="14">
                                                                <use xlink:href="/images/sprite.svg#icon-cart"></use>
                                                            </svg>
                                                            Купить
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="swiper-slide col-auto col-sm-6 col-md-4 col-lg-4 d-flex">
                                        <div class="card-product card-product-portrait">
                                            <div class="card-product-badges d-flex">
                                                <div class="card-product-badge">
                                                    <svg class="card-product-badge-media" width="45" height="45">
                                                        <use xlink:href="/images/sprite.svg#icon-sale"></use>
                                                    </svg>
                                                </div>

                                                <div class="card-product-badge">
                                                    <svg class="card-product-badge-media" width="39" height="45">
                                                        <use xlink:href="/images/sprite.svg#icon-coding"></use>
                                                    </svg>
                                                </div>

                                                <div class="card-product-badge">
                                                    <svg class="card-product-badge-media" width="45" height="45">
                                                        <use xlink:href="/images/sprite.svg#icon-no-keys"></use>
                                                    </svg>
                                                </div>
                                            </div>

                                            <div class="card-product-thumbnail">
                                                <img loading="lazy" src="uploads/catalog/product-image-3.jpg" alt="Цилиндр с вертушкой Фабрика замков E AL 60 CP Т01" class="card-product-media">
                                            </div>

                                            <a href="#link" class="card-product-title">Цилиндр с вертушкой Фабрика замков E AL 60 CP Т01</a>

                                            <div class="card-product-info-list">
                                                <div class="card-product-color-block card-product-info-block d-flex">
                                                    <label for="" class="card-product-info-title card-product-color-title">Цвет</label>

                                                    <div class="card-product-color-list d-flex flex-wrap">
                                                        <div class="card-product-color custom-control custom-color custom-color-sm">
                                                            <input type="radio" class="custom-control-input" id="card-product-color-4-1" name="card-product-color-4" checked >
                                                            <label for="card-product-color-4-1" class="custom-control-label">
                                                                <img loading="lazy" src="uploads/colors/color-brown.png" alt="Коричневый" class="custom-control-image">
                                                            </label>
                                                        </div>

                                                        <div class="card-product-color custom-control custom-color custom-color-sm">
                                                            <input type="radio" class="custom-control-input" id="card-product-color-4-2" name="card-product-color-4" >
                                                            <label for="card-product-color-4-2" class="custom-control-label">
                                                                <img loading="lazy" src="uploads/colors/color-silver.png" alt="Серебряный" class="custom-control-image">
                                                            </label>
                                                        </div>

                                                        <div class="card-product-color custom-control custom-color custom-color-sm">
                                                            <input type="radio" class="custom-control-input" id="card-product-color-4-3" name="card-product-color-4" >
                                                            <label for="card-product-color-4-3" class="custom-control-label">
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
                                                            <div class="card-product-price">187<span class="rouble" ></span></div>
                                                            <div class="card-product-old-price">499<span class="rouble" ></span></div>
                                                        </div>

                                                        <div class="card-product-sale-price text-danger">Экономия 13%</div>
                                                    </div>

                                                    <div class="card-product-cart-container col-auto">
                                                        <button type="button" class="card-product-cart d-flex align-items-center justify-content-center" data-toggle="modal" data-target="#modalAddToCart" >
                                                            <svg class="card-product-cart-media d-none d-lg-inline" width="16" height="14">
                                                                <use xlink:href="/images/sprite.svg#icon-cart"></use>
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
                        </div>

                        <div class="col-lg-3 d-flex">
                            <a href="catalog.html" class="card-banner card-banner-catalog d-flex flex-column justify-content-center">
                                <span class="row align-items-center justify-content-center">
                                    <span class="card-banner-thumbnail-container col-auto col-lg-12">
                                        <span class="card-banner-thumbnail">
                                            <svg class="card-banner-media" width="40" height="40">
                                                <use xlink:href="/images/sprite.svg#icon-catalog"></use>
                                            </svg>
                                        </span>
                                    </span>

                                    <span class="card-banner-typography-container col col-sm-auto col-lg-12">
                                        <span class="card-banner-title">Посмотреть все броненакладки</span>
                                    </span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </section>

    </main>
@stop
