<!doctype html>
<html lang="ru">


    @include('client.layouts._head')


    <body @yield('body_class')>

        @include('client.layouts._auth_menu')

        @include('client.layouts._header')

        @yield('content')

        @include('client.layouts._footer')

        {!! Asset::includeJS('client_js') !!}

    </body>


</html>
