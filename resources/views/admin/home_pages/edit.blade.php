@extends('admin.structure.inner')
{{-- Edit home pages --}}

@section('title')
    {{ $node->name }} - редактирование содержимого
@stop

@section('content')

    @include('admin.layouts._breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    {!! Form::tbModelWithErrors($homePage, $errors, ['url' => route('cc.home-pages.update', [$node->id]), 'method' => 'put', 'files' => true]) !!}

        @include('admin.shared._header_meta_field')

        {!! Form::tbFormGroupOpen('content') !!}
            {!! Form::tbLabel('content', trans('validation.attributes.content')) !!}
            {!! Form::tbTinymceTextarea('content') !!}
        {!! Form::tbFormGroupClose() !!}

        @include('admin.shared._form_meta_fields')

        @include('admin.shared._model_timestamps', ['model' => $homePage])

        <div class="action-bar">
            <button type="submit" class="btn btn-success">{{ trans('interactions.save') }}</button>
            <button type="submit" class="btn btn-primary" name="redirect_to" value="index">{{ trans('interactions.save_and_back_to_list') }}</button>
            @include('admin.structure._delete_node', ['node' => $node])
            <a href="{{ route('cc.structure.edit', [$node->id]) }}" class="btn btn-default">{{ trans('interactions.edit') }}</a>
            <a href="{{ route('cc.structure.index') }}" class="btn btn-default">{{ trans('interactions.back_to_list') }}</a>
            @if ($node->in_tree_publish)
                @include('admin.shared._show_on_site_button', ['url' => TypeContainer::getClientUrl($node)])
            @endif
        </div>

    {!! Form::close() !!}
@stop
