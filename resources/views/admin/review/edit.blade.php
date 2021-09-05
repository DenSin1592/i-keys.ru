@extends('admin.review.form', ['formData' => $formData, 'reviewList' => $reviewList])

@section('title')
    Отзыв #{{ $formData['review']->id }}
    {{ $formData['review']->name }} - редактирование
@stop

@section('submit_block')
    <button type="submit" class="btn btn-success">{{ trans('interactions.save') }}</button>
    <button type="submit" class="btn btn-primary" name="redirect_to" value="index">{{ trans('interactions.save_and_back_to_list') }}</button>
    @include('admin.review._delete_review', ['review' => $formData['review']])
    <a href="{{ route('cc.reviews.index') }}" class="btn btn-default">{{ trans('interactions.back_to_list') }}</a>
@stop
