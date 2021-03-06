<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{$metaData['meta_title'] ?? 'l-keys.ru'}}</title>

    @if (isset($metaData['meta_description']))
        <meta name="description" content="{{ $metaData['meta_description'] }}"/>
    @endif

    @if (isset($metaData['meta_keywords']))
        <meta name="keywords" content="{{ $metaData['meta_keywords'] }}"/>
    @endif

    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    {!! Asset::includeCSS('client_css') !!}

    @if (\Request::route()->getName() === "cart.show")
        <script defer id="ISDEKscript" type="text/javascript" src="{{ URL::asset('/js/client/cdek/widjet.min.js') }}"></script>
    @endif
</head>

