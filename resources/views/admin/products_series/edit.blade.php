@extends('admin.products_series.form', ['formData' => $formData])

@section('title')
    Серия #{{ $formData['model']->id }}
    {{ $formData['model']->value }} - редактирование
@stop

@section('submit_block')
    <button type="submit" class="btn btn-success">{{ trans('interactions.save') }}</button>
    <button type="submit" class="btn btn-primary" name="redirect_to" value="index">{{ trans('interactions.save_and_back_to_list') }}</button>
    @include('admin.products_series._delete')
    <a href="{{ route('cc.products-series.index') }}" class="btn btn-default">{{ trans('interactions.back_to_list') }}</a>
@stop
