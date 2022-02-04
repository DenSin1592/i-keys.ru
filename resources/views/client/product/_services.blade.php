<section class="section-product-services section-services-related">
    <div class="container">
        <div class="section-header">
            <div class="row justify-content-between">
                <div class="col">
                    <div class="section-title title-h3">Услуги</div>
                </div>

                <div class="col-auto">
                    <a href="{{route('services')}}" class="section-cta">Все услуги</a>
                </div>
            </div>
        </div>

        <div class="services-related-grid row">
            @foreach($services as $element)
                <div class="service-related-item col-lg-4">
                    <div class="card card-service-related">
                        <div class="row flex-nowrap">
                            <div class="card-thumbnail col-auto">
                                <a href="{{route('service.show', $element->alias)}}">
                                    <img loading="lazy" src="{{$element->getImgPath('icon', 'thumb', 'no-image-200x200.png')}}"
                                         width="100" height="100" alt="{{$element->name}}" class="card-media">
                                </a>
                            </div>

                            <div class="card-content col align-self-center">
                                <a href="{{route('service.show', $element->alias)}}" class="card-title title-h4">{{$element->name}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
