@extends('admin.layouts.default')

@section('main_menu_class', '')

@section('content')

    {!! Form::tbRestfulFormOpen($formData['model'], $errors, 'cc.products-series') !!}

    {!! Form::tbTextBlock('value', trans('validation.attributes.name')) !!}

    {!! Form::tbFormGroupOpen('attribute_id') !!}
    {!! Form::tbLabel('attribute_id', trans('validation.attributes.attribute_type')) !!}
    {!! Form::tbSelect('attribute_id', \App\Models\Attribute\AttributeConstants::SERIES_ATTRIBUTES_VARIANTS,null, ['disabled' => !empty($typeSeriesDisabled)]) !!}
    {!! Form::tbFormGroupClose() !!}

    <div class="action-bar">
        @yield('submit_block')
    </div>

    {!! Form::close() !!}

@stop
