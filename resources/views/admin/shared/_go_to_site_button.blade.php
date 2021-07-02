<a href="{{ $url }}" target="_blank" class="navbar-brand">
    @if ($siteName = \Setting::get('admin.site_name'))
        {!! $siteName !!} ({{ \Str::lower(trans('interactions.go_to_site')) }})
    @else
        {!! trans('interactions.go_to_site') !!}
    @endif
</a>
