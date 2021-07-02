{{-- Common include in head --}}

<meta charset="utf-8" />
<title>@yield('title')</title>
<meta name="csrf-token" content="{{ csrf_token() }}"/>

{!! Asset::includeCSS('admin_css') !!}

@yield('custom_css')
