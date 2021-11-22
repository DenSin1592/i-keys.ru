@extends('client.layouts.default')

@section('body_class')
    class='home-page d-flex flex-column'
@endsection

@section('content')
    <main class="main-box flex-shrink-0 flex-grow-1">
        @include('client.categories._section_display')

        <section class="section-catalog">
            <div class="container">
                <div class="row">

                    @if(!empty($filter['filterVariants']))

                        @include('client.categories._filter_block')

                    @endif

                    <div class="catalog-content-container col-xl-9">

                        @include('client.categories._types_block')


                        @include('client.categories._selected_variants')

                        @include('client.categories._catalog_controls')


                        @if(\Arr::get($filter, 'currentFilterQuery.view') === \App\Models\Product::VIEW_LIST)
                            {{--  @include('client.categories._products_list')--}}Товары списком
                        @else
                            @include('client.categories._products_grid._block')
                        @endif

                        {{--@if (count($productsData) === 0 && !empty($filter['filterVariants']))
                            <div class="font-weight-bold">
                                К сожалению, по выбранным Вами параметрам не найдено ни одного товара. <br>
                                Попробуйте расширить критерии поиска или посмотреть весь <a href="{{ UrlBuilder::getUrl($category) }}">каталог</a>.
                            </div>
                        @endif--}}



                        {!! $paginator->onEachSide(1)->links('client.shared.pagination.client') !!}


                        @include('client.categories._content._bottom', ['model' => $category])

                    </div>
                </div>
            </div>
        </section>

        @include('client.categories._section_services')

    </main>
@stop
