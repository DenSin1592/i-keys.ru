@extends('admin.layouts.default')

@section('title', 'Субдомены')

@section('content')
    <div id="order-list" class="element-list-wrapper">

        <div class="element-container header-container">
        </div>

        <div>
            @include('admin.subdomains._list')
        </div>

        <div>
            <a href="{{ route('cc.subdomains.create') }}" class="btn btn-success btn-xs">Добавить субдомен</a>
        </div>

    </div>
@stop
