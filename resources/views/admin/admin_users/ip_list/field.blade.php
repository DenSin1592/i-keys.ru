<fieldset class="bordered-group form-group manage-ip-container">
    <legend>Разрешённые IP-адреса</legend>

    {!! Form::tbFormGroupOpen('allowed_ips') !!}
        {!! Form::tbLabel('allowed_ips', 'IP-адрес') !!}
        <div class="ips-container">
            @forelse($allowed_ips as $key => $ip)
                @include('admin.admin_users.ip_list._ip', ['ip' => $ip, 'key' => $key])
            @empty
                @include('admin.admin_users.ip_list._ip', ['ip' => '', 'key' => 0])
            @endforelse
        </div>
        <div class="add-new">
            <a href="#">Добавить IP-адрес</a>
            <a href="#" id="add-my-ip"
               data-myip="{{ Request::getClientIp() }}">Добавить текуший IP-адрес ({{ Request::getClientIp() }})</a>
            <div class="add-container">
                @include('admin.admin_users.ip_list._ip', ['ip' => '', 'key' => null, 'disabled' => true])
            </div>
        </div>
    {!! Form::tbFormGroupClose() !!}
</fieldset>
