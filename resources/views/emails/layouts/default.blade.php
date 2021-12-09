<!DOCTYPE html>
<html style="font-size: 14pt; color: #242424; background-color: white;">
<head>
    <meta charset="utf-8"/>
</head>
<body style="margin: 0;">

@include('emails.layouts._header')

<div style="margin: 15px;">
    @yield('content')
</div>

@section('footer')
    @include('emails.layouts._footer')
@show


</body>
</html>