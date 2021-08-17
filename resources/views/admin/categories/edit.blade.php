@extends('admin.categories.inner')

@section('title')
    {{ $formData['category']->name }} - редактирование
@stop

@section('content')

    @if (isset($breadcrumbs))
        @include('admin.shared._catalog_breadcrumbs', ['breadcrumbs' => $breadcrumbs])
    @endif

    {!! Form::tbModelWithErrors($formData['category'], $errors, ['url' => route('cc.categories.update', [$formData['category']->id]), 'method' => 'put', 'files' => true, 'autocomplete' => 'off']) !!}

        @include('admin.categories._form_fields')

        {!! Form::hidden('position', $formData['category']->position) !!}

        <div class="action-bar">
            <button type="submit" class="btn btn-success">{{ trans('interactions.save') }}</button>
            <button type="submit" class="btn btn-primary" name="redirect_to" value="index">{{ trans('interactions.save_and_back_to_list') }}</button>
            @include('admin.categories._delete_category', ['category' => $formData['category']])
            @if ($formData['parent'])
                <a href="{{ route('cc.categories.show', $formData['parent']->id) }}" class="btn btn-default">{{ trans('interactions.back_to_list') }}</a>
            @else
                <a href="{{ route('cc.categories.index') }}" class="btn btn-default">{{ trans('interactions.back_to_list') }}</a>
            @endif
            @if ($formData['category']->in_tree_publish)
                @include('admin.shared._show_on_site_button', ['url' => CatalogUrlBuilder::buildCategoryUrl($formData['category'])])
            @endif
        </div>

    {!! Form::close() !!}
@stop
