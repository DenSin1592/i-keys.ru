@extends('admin.layouts.default')

@section('title', 'Отзывы')

@section('content')
    @if (isset($breadcrumbs))
        @include('admin.layouts._breadcrumbs', ['breadcrumbs' => $breadcrumbs])
    @endif
    <div class="element-list-wrapper review-list">
        <div class="element-container header-container">
            <div class="id">{{ trans('validation.attributes.review_id') }}</div>
            <div class="score">{{ trans('validation.attributes.review_score') }}</div>
            <div class="name">{{ trans('validation.attributes.review_name') }}</div>
            <div class="content">{{ trans('validation.attributes.review_content') }}</div>
            <div class="review_date">{{ trans('validation.attributes.review_date') }}</div>
            <div class="publish">{{ trans('validation.attributes.publish') }}</div>
            <div class="control">{{ trans('interactions.controls') }}</div>
        </div>

        <div>
            @include('admin.review._review_list', ['reviewList' => $reviewList])
            @include('admin.shared._pagination_links', ['paginator' => $reviewList])
        </div>

        <div>
            <a href="{{ route('cc.reviews.create') }}" class="btn btn-success btn-xs">Добавить отзыв</a>
        </div>
    </div>
@stop
