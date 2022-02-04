@extends('client.layouts.default')


@section('body_class')
    class='services-page d-flex flex-column'
@endsection


@section('content')
    <main class="main-box flex-shrink-0 flex-grow-1">
        <section class="section-display section-dark" >
            <div class="container">
                @include('client.shared.breadcrumbs._breadcrumbs')

                <h1 class="display-title title-h1 text-uppercase">Услуги</h1>
            </div>
        </section>

        <section class="section-posts section-dark">
            <div class="container">
                <div class="row">
                    <div class="section-posts-column col-lg-6">
                        <div class="posts-grid row">
                            @foreach($servicesFirstBlock as $service)
                            <div class="post-item col-12">
                                <div class="card-post">
                                    <div class="row">
                                        <div class="card-post-thumbnail-container col-sm-4 col-xl-6">
                                            <a href="{{route('service.show', $service->alias)}}" class="card-post-thumbnail">
                                                <img loading="lazy" src="{{ $service->getImgPath('image', 'list','no-image-200x200.png') }}" width="395" height="287" alt="{{ $service->name }}" class="card-post-media">
                                            </a>
                                        </div>

                                        <div class="card-post-typography-container col-sm-8 col-xl-6">
                                            <div class="card-post-title title-h2">
                                                <a href="{{route('service.show', $service->alias)}}">{{ $service->name }}</a>
                                            </div>

                                            <div class="card-post-description">{!! $service->description !!}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="section-posts-column col-lg-6">
                        <div class="card-post card-post-featured" style="background-image: url('uploads/posts/post-featured-thumbnail-1.jpg');" >
                            <div class="card-post-inner d-flex flex-column align-items-start">
                                <div class="card-post-title title-h2">
                                    <a href="#">Мастер-системы</a>
                                </div>

                                <div class="card-post-description">Мастер-система представляет собой особую систему контроля и управления специальным доступом, принцип работы которой заключается в механическом</div>

                                <a href="#" class="card-post-cta btn mt-auto" >Подробнее</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <a href="https://wa.me/{{Setting::get("site_content.wa_phone")}}" class="card-banner card-banner-landscape card-banner-whatsapp">
                    <div class="row">
                        <div class="card-banner-thumbnail-container col-2 col-md-1 d-flex justify-content-center">
                            <div class="card-banner-thumbnail">
                                <img loading="lazy" src="{{asset('images/client/icons/icon-whatsapp-white.svg')}}" width="62" height="62" alt="Связаться по WhatsApp" class="card-banner-media">
                            </div>
                        </div>

                        <div class="card-banner-typography-container col-10 col-md-11 align-self-center">
                            <div class="card-banner-title title-h3">Свяжитесь с нами по WhatsApp</div>

                            <div class="card-banner-description">Если у вас появились вопросы в выборе замка. Мы с радостью Вас проконсультируем.</div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="container">
                <div class="posts-grid row">
                    @foreach($servicesSecondBlock as $service)
                    <div class="post-item col-lg-6">
                        <div class="card-post">
                            <div class="row">
                                <div class="card-post-thumbnail-container col-sm-4 col-xl-6">
                                    <a href="{{route('service.show', $service->alias)}}" class="card-post-thumbnail">
                                        <img loading="lazy" src="{{ $service->getImgPath('image', 'list','no-image-200x200.png') }}" width="395" height="287" alt="{{ $service->name }}" class="card-post-media">
                                    </a>
                                </div>

                                <div class="card-post-typography-container col-sm-8 col-xl-6">
                                    <div class="card-post-title title-h2">
                                        <a href="{{route('service.show', $service->alias)}}">{{ $service->name }}</a>
                                    </div>

                                    <div class="card-post-description">{!! $service->description !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
@endsection

@section('modals')

@endsection
