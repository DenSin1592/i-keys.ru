<!doctype html>
<html lang="ru">


    @include('client.layouts._head')


    <body @yield('body_class')>

        @include('client.layouts._auth_menu')

        @include('client.layouts._header')

        @yield('content')

        @include('client.layouts._footer')

        @include('client.layouts._offcanvas')

        {!! Asset::includeJS('client_js') !!}

        @yield('modals')
        @include('client.shared.modal._message')

    </body>


</html>
