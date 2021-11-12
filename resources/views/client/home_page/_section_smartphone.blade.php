<section class="section-smartphone" style="background-image: url('{{asset('/images/client/sections/section-smartphone/smartphone-bg.jpg')}}');" >
    <div class="container">
        <div class="row">
            <div class="smartphone-typography-container col-lg-5 order-lg-1">
                <div class="section-header">
                    <div class="section-title title-h1">Если у вас под рукой смартфон, то</div>
                </div>

                <div class="smartphone-steps-grid row">
                    <div class="smartphone-step-item col-md-10 col-lg-12">
                        <div class="card card-smartphone">
                            <div class="row flex-nowrap">
                                <div class="card-thumbnail col-auto">
                                    <img loading="lazy" src="{{asset('/images/client/sections/section-smartphone/smartphone-step-1.jpg')}}" width="114" height="114" alt="" class="card-media">
                                </div>

                                <div class="card-content col align-self-center">
                                    <div class="card-text">Сфотографируйте ключ, замок в двери, замок с торца двери, если дверь открыта</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="smartphone-step-item col-md-10 col-lg-12">
                        <div class="card card-smartphone">
                            <div class="row flex-nowrap">
                                <div class="card-thumbnail col-auto">
                                    <img loading="lazy" src="{{asset('/images/client/sections/section-smartphone/smartphone-step-2.jpg')}}" width="114" height="114" alt="" class="card-media">
                                </div>

                                <div class="card-content col align-self-center">
                                    <div class="card-text">Отправьте фотографии нам по
                                        <a href="https://wa.me/{{Setting::get("site_content.wa_phone")}}">whatsapp</a>,
                                        <a href="https://t.me/{{Setting::get("site_content.telegram_phone")}}">телеграмм</a> или
                                        <a href="viber://chat?number={{Setting::get("site_content.viber_phone")}}">вайбер</a>.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="smartphone-step-item col-md-10 col-lg-12">
                        <div class="card card-smartphone">
                            <div class="row flex-nowrap">
                                <div class="card-thumbnail col-auto">
                                    <img loading="lazy" src="{{asset('/images/client/sections/section-smartphone/smartphone-step-3.jpg')}}" width="114" height="114" alt="" class="card-media">
                                </div>

                                <div class="card-content col align-self-center">
                                    <div class="card-text">В течение 10 минут* мастер свяжется с вами, озвучит предварительную стоимость и оформит заявку на выезд.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="smartphone-steps-hint">* - в рабочее время с момента получения заявки</div>
            </div>

            <div class="smartphone-instruction-container col-md-5 col-lg-3 col-xxl-2 order-lg-3">
                <div class="smartphone-instruction-block">
                    <div class="smartphone-instruction-headline title-h2">Вот подробная видеоинструкция</div>

                    <div class="card-smartphone-instruction-video card-video">
                        <div class="card-video-thumbnail">
                            <img loading="lazy" src="{{asset('/uploads/services/service-item-1.jpg')}}" width="257" height="164" alt="" class="card-video-media">
                        </div>
                    </div>

                    <div class="smartphone-instruction-hint">Если у вас нет возможности сделать фото, попробуйте определить свой замок по этой <a href="#link">инструкции</a> и позвоните нам.</div>
                </div>
            </div>

            <div class="smartphone-media-container col-md-7 col-lg-4 col-xxl-5 order-lg-2 d-flex flex-column">
                <figure class="smartphone-media-figure d-flex flex-column align-items-center justify-content-end">
                    <img loading="lazy" src="{{asset('/images/client/sections/section-smartphone/smartphone-with-hand-image.png')}}" width="556" height="661" alt="" class="smartphone-media">
                </figure>
            </div>
        </div>
    </div>
</section>
