@if (isset($currentAdminUser))
    <div id="auth-menu" class="closed">
        <div class="content-wrapper">
            @if (isset($authEditLink))
                <div class="action-container">
                    <a target="_blank" href="{{ $authEditLink }}"><span class="glyphicon glyphicon-pencil"></span>Редактировать</a>
                </div>
                <div class="divider-vertical"></div>
            @endif
            <div class="login">
                Ваш логин: <a href="{{ route('cc.home') }}">{{ data_get($currentAdminUser, 'username') }}</a>
            </div>
            <div class="divider-vertical"></div>
        </div>

        <span class="toggle-button" data-action="toggle">
            <img class="logotype" src="{{ Asset::timed('/images/admin/diol.svg') }}">
        </span>
    </div>
@endif


