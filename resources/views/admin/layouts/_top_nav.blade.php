{{-- Top navigation --}}

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#top-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a id="logotype" href="{{ route('cc.home') }}">
                <img src="{{ Asset::timed('images/admin/diol.png') }}" alt="Проект">
            </a>
        </div>

        <div class="collapse navbar-collapse" id="top-navbar-collapse">
            @if (isset($currentAdminUser))
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <span class="navbar-text">Ваш логин: <strong>{{ $currentAdminUser['username'] }}</strong></span>
                </li>
                <li>
                    <a href="{{ route('cc.logout') }}" data-method="delete" id="cc-logout">
                        <span class="glyphicon glyphicon-off"></span> Выход
                    </a>
                </li>
            </ul>
            @endif
            <div class="project">
                @section('go_to_site_link')
                    @if (Route::has('home'))
                        @include('admin.shared._go_to_site_button', ['url' => route('home')])
                    @endif
                @show
            </div>
        </div>
    </div>
</nav>
