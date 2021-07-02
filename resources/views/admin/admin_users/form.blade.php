@extends('admin.layouts.default')
{{-- Layout for user forms --}}

@section('main_menu_class', 'closed')

@section('second_column')
    {!! Html::additionalMenuOpen(['resize' => 'admin-users']) !!}
        <div class="menu-wrapper">
            <div class="menu-header">
                <a href="{{ route('cc.admin-users.index') }}">Администраторы</a>
            </div>

            <ul class="scrollable-container">
                @foreach ($user_list as $u)
                    <li>
                        <div class="menu-element {{ $user->id == $u->id ? 'active' : '' }}">
                            <div class="name">
                                <a href="{{ route('cc.admin-users.edit', [$u->id]) }}"
                                   title="{{ $u->username }}">{{ $u->username }}</a>
                            </div>
                            <div class="control">
                                @include('admin.admin_users._list_controls', ['user' => $u])
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="menu-footer">
                <a href="{{ route('cc.admin-users.create') }}" class="btn btn-success btn-xs">Добавить администратора</a>
            </div>
        </div>
    {!! Html::additionalMenuClose() !!}
@stop

@section('content')

    {!! Form::tbRestfulFormOpen($user, $errors, 'cc.admin-users', ['id' => 'admin_user_form']) !!}

        {!! Form::tbFormGroupOpen('username') !!}
            {!! Form::tbLabel('username', trans('validation.attributes.username')) !!}
            {!! Form::tbText('username') !!}
        {!! Form::tbFormGroupClose() !!}

        {!! Form::tbFormGroupOpen('password') !!}
            {!! Form::tbLabel('password', trans('validation.attributes.password')) !!}
            {!! Form::tbPassword('password') !!}
        {!! Form::tbFormGroupClose() !!}

        {!! Form::tbFormGroupOpen('password_confirmation') !!}
            {!! Form::tbLabel('password', trans('validation.attributes.password_confirmation')) !!}
            {!! Form::tbPassword('password_confirmation') !!}
        {!! Form::tbFormGroupClose() !!}

        @if (Auth::user()->id != $user->id)
            {!! Form::tbFormGroupOpen('active') !!}
                <input type="hidden" name="active" value="0"/>
                <label class="checkbox-inline">
                    {!! Form::checkbox('active', 1) !!}
                    <span class="bold">{{ trans('validation.attributes.active') }}</span>
                </label>
            {!! Form::tbFormGroupClose() !!}
        @endif

        @include('admin.admin_users.ip_list.field', ['allowed_ips' => old('allowed_ips', \Arr::get($user, 'allowed_ips', []))])
        @include('admin.shared._model_timestamps', ['model' => $user])

        <div class="action-bar">
            @yield('submit_block')
        </div>

    {!! Form::close() !!}

@stop
