<ol class="breadcrumb">

    @foreach ($breadcrumbs->getBreadcrumbs() as  $breadcrumb)
        @if ($loop->last)
            <li class="breadcrumb-item active" aria-current="page">{!! $breadcrumb['name'] !!}</li>
        @else
            <li class="breadcrumb-item">
                @if (is_null($breadcrumb['url']))
                    {!! $breadcrumb['name'] !!}
                @else
                    <a href="{{ $breadcrumb['url'] }}">{!! $breadcrumb['name'] !!}</a>
                @endif
            </li>
        @endif
    @endforeach

</ol>
