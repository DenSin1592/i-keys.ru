@extends('admin.structure.inner')

@section('title')
{{ $node->name }} - редактирование
@stop

@section('content')

    @include('admin.layouts._breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    {!! Form::tbModelWithErrors($node, $errors, ['url' => route('cc.structure.update', [$node->id]), 'method' => 'put']) !!}

        @include('admin.structure._node_form_fields')

        {!! Form::hidden('position', $node->position) !!}

        <div class="action-bar">
            <button type="submit" class="btn btn-success">{{ trans('interactions.save') }}</button>
            <button type="submit" class="btn btn-primary" name="redirect_to" value="index">{{ trans('interactions.save_and_back_to_list') }}</button>
            @include('admin.structure._delete_node', ['node' => $node])
            <a href="{{ TypeContainer::getContentUrl($node) }}" class="btn btn-default">{{ trans('interactions.edit') }}</a>
            <a href="{{ route('cc.structure.index') }}" class="btn btn-default">{{ trans('interactions.back_to_list') }}</a>
            @if ($node->in_tree_publish)
                @include('admin.shared._show_on_site_button', ['url' => TypeContainer::getClientUrl($node)])
            @endif
        </div>

    {!! Form::close() !!}
@stop

@if ($node->in_tree_publish)
    @section('go_to_site_link')
        @include('admin.shared._go_to_site_button', ['url' => TypeContainer::getClientUrl($node)])
    @stop
@endif
