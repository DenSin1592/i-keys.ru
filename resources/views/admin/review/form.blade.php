@extends('admin.layouts.default')
{{-- Layout for user forms --}}

@section('main_menu_class', 'closed')

@section('second_column')
    {!! Html::additionalMenuOpen(['resize' => 'review']) !!}
    <div class="menu-wrapper">
        <div class="menu-header">
            <a href="{{ route('cc.reviews.index') }}">Отзывы</a>
        </div>

        <ul class="scrollable-container">
            @foreach ($reviewList as $review)
                <li>
                    <div class="menu-element {{ $formData['review']->id == $review->id ? 'active' : '' }}">
                        <div class="name">
                            <a href="{{ route('cc.reviews.edit', [$review->id]) }}"
                               title="{{ $review->name }}">{{ $review->name }}</a>
                        </div>
                        <div class="control">
                            @include('admin.review._list_controls', ['review' => $review])
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

        @include('admin.shared._pagination_simple_links', ['paginator' => $reviewList])

        <div class="menu-footer">
            <a href="{{ route('cc.reviews.create') }}" class="btn btn-success btn-xs">Добавить отзыв</a>
        </div>
    </div>
    {!! Html::additionalMenuClose() !!}
@stop

@section('content')

    {!! Form::tbRestfulFormOpen($formData['review'], $errors, 'cc.reviews', ['id' => 'review_form']) !!}

        {!! Form::tbTextBlock('name', trans('validation.attributes.review_name')) !!}

        {!! Form::tbCheckboxBlock('publish') !!}

        {!! Form::tbCheckboxBlock('on_home_page') !!}

        {!! Form::tbTextBlock('email') !!}

        @include('admin.review._score')

        {!! Form::tbTextareaBlock('content', trans('validation.attributes.review_content')) !!}

        {!! Form::tbTextareaBlock('content_answer', trans('validation.attributes.review_content_answer')) !!}

        @include('admin.review._product_field')

        @include('admin.review._date_field', ['formData' => $formData])

        {!! Form::tbCheckboxBlock('keep_review_date') !!}

        {!! Form::hidden('ip') !!}

        @include('admin.shared._model_timestamps', ['model' => $formData['review']])

        <div class="action-bar">
            @yield('submit_block')
        </div>

    {!! Form::close() !!}

@stop
