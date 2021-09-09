@extends('admin.layouts.default')

@section('title')
Статус синхронизации с 1С
@stop

@section('content')
@include('admin.exchange._import._block')
@include('admin.exchange._export._block')
@stop