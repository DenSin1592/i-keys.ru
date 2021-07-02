<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        {!! Asset::includeCSS('client_css') !!}
    </head>
    <body>
        <h1>Hello world!</h1>
    </body>
    {!! Asset::includeJS('client_js') !!}
</html>
