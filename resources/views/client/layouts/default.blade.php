<!doctype html>
<html lang="ru">

    <head>
        <title>{{$metaData['meta_title'] ?? 'l-keys.ru'}}</title>

        @if (isset($metaData['meta_description']))
            <meta name="description" content="{{ $metaData['meta_description'] }}"/>
        @endif

        @if (isset($metaData['meta_keywords']))
            <meta name="keywords" content="{{ $metaData['meta_keywords'] }}"/>
        @endif

        <meta name="csrf-token" content="{{ csrf_token() }}"/>

        {!! Asset::includeCSS('client_css') !!}
    </head>

    <body @yield('body_class')>

        @include('client.layouts._auth_menu')

        @yield('content')

        {!! Asset::includeJS('client_js') !!}
    </body>
</html>
