@if(!empty($productData['attributesData'][\App\Models\Attribute\AttributeConstants::OTHER]))
    <section class="section-product-specifications">
        <div class="container">
            <div class="section-header">
                <div class="section-title title-h3 font-family-secondary">Параметры</div>
            </div>

            <div class="row">
                <div class="product-specifications-container col-xxl-8">
                    <div class="product-specifications-grid row">

                        @if(!empty($productData['attributesData'][\App\Models\Attribute\AttributeConstants::OTHER][\App\Models\Attribute\AttributeConstants::GENERAL]))
                            <div class="product-specifications-column col-md-6">
                                <div class="product-specifications-block">
                                    <div class="product-specifications-headline">Общие</div>

                                    <ul class="product-specifications-list list-unstyled">
                                        @foreach($productData['attributesData'][\App\Models\Attribute\AttributeConstants::OTHER][\App\Models\Attribute\AttributeConstants::GENERAL] as $elem)
                                            <li class="product-specifications-item row align-items-center">
                                                <span
                                                    class="product-specifications-title col-sm-6">{{$elem['name']}}</span>
                                                <span
                                                    class="product-specifications-text col-sm-6">{{$elem['values'][0]}}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        @if(!empty($productData['attributesData'][\App\Models\Attribute\AttributeConstants::OTHER][\App\Models\Attribute\AttributeConstants::TECHNICAL]))
                            <div class="product-specifications-column col-md-6">
                                <div class="product-specifications-block">
                                    <div class="product-specifications-headline">Технические</div>

                                    <ul class="product-specifications-list list-unstyled">
                                        @foreach($productData['attributesData'][\App\Models\Attribute\AttributeConstants::OTHER][\App\Models\Attribute\AttributeConstants::TECHNICAL] as $elem)
                                            <li class="product-specifications-item row align-items-center">
                                                <span
                                                    class="product-specifications-title col-sm-6">{{$elem['name']}}</span>
                                                <span
                                                    class="product-specifications-text col-sm-6">{{$elem['values'][0]}}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        @if(!empty($productData['attributesData'][\App\Models\Attribute\AttributeConstants::OTHER][\App\Models\Attribute\AttributeConstants::KEY]))
                            <div class="product-specifications-column col-md-6">
                                <div class="product-specifications-block">
                                    <div class="product-specifications-headline">Параметры ключа</div>

                                    <ul class="product-specifications-list list-unstyled">
                                        @foreach($productData['attributesData'][\App\Models\Attribute\AttributeConstants::OTHER][\App\Models\Attribute\AttributeConstants::KEY] as $elem)
                                            <li class="product-specifications-item row align-items-center">
                                                <span
                                                    class="product-specifications-title col-sm-6">{{$elem['name']}}</span>
                                                <span
                                                    class="product-specifications-text col-sm-6">{{$elem['values'][0]}}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="product-documents-container col-xxl-3 offset-xxl-1">
                    <div class="product-documents-block">
                        <div class="product-documents-headline">Файлы для скачивания</div>

                        <ul class="product-documents-list list-unstyled row">
                            <li class="product-documents-item col-md-4 col-xxl-12">
                                <a href="javascript:void(0);" class="card-document d-inline-flex align-items-center">
                                            <span class="card-document-thumbnail">
                                                <svg class="card-document-media" width="44" height="44">
                                                    <use
                                                        xlink:href="{{asset('/images/client/sprite.svg#icon-pdf')}}"></use>
                                                </svg>
                                            </span>

                                    <span class="card-document-typogpraphy">
                                                <span class="card-document-title">Инструкция</span>
                                                <span class="card-document-size text-muted">12 мб</span>
                                            </span>
                                </a>
                            </li>

                            <li class="product-documents-item col-md-4 col-xxl-12">
                                <a href="javascript:void(0);" class="card-document d-inline-flex align-items-center">
                                            <span class="card-document-thumbnail">
                                                <svg class="card-document-media" width="44" height="44">
                                                    <use
                                                        xlink:href="{{asset('/images/client/sprite.svg#icon-pdf')}}"></use>
                                                </svg>
                                            </span>

                                    <span class="card-document-typogpraphy">
                                                <span class="card-document-title">Сертификат</span>
                                                <span class="card-document-size text-muted">2 мб</span>
                                            </span>
                                </a>
                            </li>

                            <li class="product-documents-item col-md-4 col-xxl-12">
                                <a href="javascript:void(0);" class="card-document d-inline-flex align-items-center">
                                            <span class="card-document-thumbnail">
                                                <svg class="card-document-media" width="44" height="44">
                                                    <use
                                                        xlink:href="{{asset('/images/client/sprite.svg#icon-pdf')}}"></use>
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
@endif
