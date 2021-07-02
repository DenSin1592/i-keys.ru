@extends('admin.layouts.guest')
{{-- Login form --}}

@section('title')
    Авторизация

    @if ($siteName = \Setting::get('admin.site_name'))
        ({!! \Str::lower($siteName) !!})
    @endif
@stop

@section('content')
    {!! Form::open(array('url' => route('cc.login'))) !!}

        <div class="form-group {{ $incorrect ? 'has-error' : '' }}">
            {!! Form::label('username', 'Имя пользователя', ['class' => 'control-label']) !!}
            {!! Form::text('username', $credentials['username'], ['class' => 'form-control', 'placeholder' => 'Введите логин', 'autofocus' => 'autofocus']) !!}
        </div>

        <div class="form-group {{ $incorrect ? 'has-error' : '' }}">
            {!! Form::label('password', 'Пароль', ['class' => 'control-label']) !!}
            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Введите пароль']) !!}
        </div>

        <div class="remember-me">
            <label>{!! Form::checkbox('remember', 1, $remember) !!} Запомнить меня</label>
        </div>

        <div class="submit-container">
            <button type="submit" class="btn btn-primary">Вход</button>
        </div>

    {!! Form::close() !!}
@stop
