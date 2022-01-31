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
                        <p>По запросу "{{ $query }}" не найдено ни одного товара {{Request::get('category_for_search') !== 'all' ? 'в разделе "'. \App\Models\Category::MAPPING_ALIASES[Request::get('category_for_search')].'"' : '' }}.</p>
                    @endif
                </div>
            </div>
        </section>

        @if ($paginator->total() === 0 && (Request::get('category_for_search') === 'all'))

            @else
            <section class="section-search">
            <div class="container">
                <div class="search-products-block">
                    <ul class="search-nav-tabs nav nav-tabs d-flex flex-nowrap">
                       @foreach($tabsData as $element)
                            <li class="nav-item" role="presentation">
                                <a class="nav-link @if($element['isActive']) active @endif" href="{{$element['url']}}">{{$element['name']}}</a>
                            </li>
                        @endforeach
                    </ul>

                    @if ($paginator->total() > 0)
                        <div class="search-tab-content tab-content">
                        <div class="tab-pane fade show active">
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

                    </div>
                    @endif
                </div>

                {!! $paginator->onEachSide(1)->links('client.shared.pagination.client') !!}

            </div>
        </section>
        @endif

    </main>
@endsection
