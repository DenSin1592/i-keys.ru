@extends('admin.layouts.default')

@section('main_menu_class', '')

@section('content')

    {!! Form::tbRestfulFormOpen($formData['model'], $errors, 'cc.products-series',) !!}

        {!! Form::tbTextBlock('name', trans('validation.attributes.review_name')) !!}

{{--        {!! Form::tbCheckboxBlock('publish') !!}--}}

{{--        {!! Form::tbCheckboxBlock('on_home_page') !!}--}}

{{--        {!! Form::tbTextBlock('email') !!}--}}

{{--        @include('admin.review._score')--}}

{{--        {!! Form::tbTextareaBlock('content', trans('validation.attributes.review_content')) !!}--}}

{{--        {!! Form::tbTextareaBlock('content_answer', trans('validation.attributes.review_content_answer')) !!}--}}

{{--        @include('admin.review._product_field')--}}

{{--        @include('admin.review._date_field', ['formData' => $formData])--}}

{{--        {!! Form::tbCheckboxBlock('keep_review_date') !!}--}}

{{--        {!! Form::hidden('ip') !!}--}}

{{--        @include('admin.shared._model_timestamps', ['model' => $formData['review']])--}}

        <div class="action-bar">
            @yield('submit_block')
        </div>

    {!! Form::close() !!}

@stop
