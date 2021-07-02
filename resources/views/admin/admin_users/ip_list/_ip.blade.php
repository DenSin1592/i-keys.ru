<div class="ip-container {{ $errors->has('allowed_ips_' . $key) ? 'ip-has-error' : '' }}">
    <input class="ip-control"
           autocomplete="off"
           type="text"
           name="allowed_ips[{{ $key }}]"
           value="{{ $ip }}"
           @if (!empty($disabled)) disabled @endif
           />
    <label>
        <input type="checkbox" class="toggle-ip-v6" {{ strpos($ip, ':') !== false ? 'checked' : '' }} />
        ipv6
    </label>

    <a href="#" class="glyphicon glyphicon-trash remove-ip"></a>

    @if ($errors->has('allowed_ips.' . $key))
        <div class="validation-errors">
            @foreach ($errors->get('allowed_ips.' . $key) as $e)
                <p>{{ $e }}</p>
            @endforeach
        </div>
    @endif
</div>
