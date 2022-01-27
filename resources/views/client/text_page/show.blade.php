@extends('client.layouts.default')


@section('body_class')
    class="article-page d-flex flex-column"
@endsection


@section('content')
    <main class="main-box flex-shrink-0 flex-grow-1 section-gray">
        <section class="section-display section-dark" >
            <div class="container">

                @include('client.shared.breadcrumbs._breadcrumbs')

                <h1 class="display-title title-h1 text-uppercase">{!! $metaData['h1'] !!}</h1>

            </div>
        </section>

        <section class="section-article">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-10 offset-xxl-1">
                        <article class="article-post">
                            {!! $textPage->content !!}
                        </article>
                    </div>
                </div>
            </div>
        </section>
    </main>
@stop
