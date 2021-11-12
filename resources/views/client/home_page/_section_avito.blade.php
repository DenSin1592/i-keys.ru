<section class="section-content">
    <div class="container">
        <div class="row">
            <div class="section-media-container col-lg-5 col-xl-6 order-1 order-lg-0">
                <figure class="section-media-figure d-flex flex-column align-items-center justify-content-center">
                    <img loading="lazy" src="{{asset('/images/client/sections/section-avito/avito-image.jpg')}}" width="494" height="499" alt="Авито" class="section-media">
                </figure>
            </div>

            <div class="section-typography-container col-lg-7 col-xl-6">
                <div class="section-header">
                    <div class="section-title title-h1">А может на авито?</div>
                </div>

                <div class="section-text-lead title-h2">Если будете искать на Авито, то будьте готовы к тому что:</div>

                <ul class="section-dash-list list-dash list-unstyled">
                    <li>увидите десятки одинаковых объявлений диспетчеров, а не специалистов</li>
                    <li>фото в объявлении может не соответствовать приехавшему мастеру</li>
                    <li>объявление может разместить мошенник</li>
                    <li>показанная цена ниже реальной в 2-3 и более раз</li>
                    <li>по факту приезда цена вообще может оказаться в 5-6 раз выше, но отказываться будет уже поздно</li>
                </ul>

                <div class="section-contact-block contact-block">
                    <div class="contact-title title-h2">Не рискуйте — обращайтесь к нам!</div>
                    <div class="contact-text">Позвоните напрямую нашему мастеру <a href="tel:84950957797">8-495-095-77-97</a></div>

                    <a href="https://wa.me/{{Setting::get("site_content.wa_phone")}}" class="contact-social-button contact-social-whatsapp-button d-flex align-items-center">
                        <div class="contact-social-thumbnail">
                            <img src="{{asset('/images/client/icons/icon-whatsapp.svg')}}" width="40" height="39" alt="WhatsApp" class="contact-social-image">
                        </div>

                        <div class="contact-social-content">
                            <div class="contact-social-text">Или свяжитесь с нами по WhatsApp</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
