<a href="{{ $url }}" target="_blank" class="navbar-brand">
    @if ($siteName = \Setting::get('general.site_name'))
        {!! $siteName !!} ({{ \Str::lower(trans('interactions.go_to_site')) }})
    @else
        {!! trans('interactions.go_to_site') !!}
    @endif
</a>
