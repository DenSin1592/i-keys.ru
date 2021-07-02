@extends('admin.layouts.default')

@section('title')
    Администраторы
@stop

@section('content')
    <div class="element-list-wrapper user-list">
        <div class="element-container header-container">
            <div class="name">{{ trans('validation.attributes.username') }}</div>
            <div class="role"></div>
            <div class="ip">{{ trans('validation.attributes.allowed_ips') }}</div>
            <div class="control">{{ trans('interactions.controls') }}</div>
        </div>

        <ul class="element-list scrollable-container">
            @foreach ($user_list as $user)
                <li>
                    <div class="element-container">
                        <div class="name">
                            <a href="{{ route('cc.admin-users.edit', [$user->id]) }}">
                                {{ $user->username }}
                            </a>
                        </div>
                        <div class="role">
                            @if ($user->super)
                                <span class="super-user">Суперпользователь</span>
                            @endif
                        </div>
                        <div class="ip">
                            @if (count($user->allowed_ips) == 0 || count($user->allowed_ips) == 1 && $user->allowed_ips[0] == '')
                                Все IP
                            @else
                                {!! implode('<br />', $user->allowed_ips) !!}
                            @endif
                        </div>
                        <div class="control">
                            @include('admin.admin_users._list_controls')
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

        <div>
            <a href="{{ route('cc.admin-users.create') }}" class="btn btn-success btn-xs">Добавить администратора</a>
        </div>
    </div>
@stop
