<ol class="breadcrumb">
    @foreach($breadcrumbs as $crumbIndex => $crumb)
        <li>
            @if ((empty($crumb['url'])))
                {{ $crumb['name'] }}
            @else
                <a href="{{ $crumb['url'] }}">{{ $crumb['name'] }}</a>
            @endif
        </li>
    @endforeach
</ol>
