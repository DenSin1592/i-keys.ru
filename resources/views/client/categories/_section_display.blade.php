<section class="section-display section-dark" style="background-image: url('{{asset('/images/client/sections/section-display/display-keys-bg.jpg')}}');" >
    <div class="container">
        <nav aria-label="breadcrumb">
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
        </nav>

        <h1 class="display-title title-h1 text-uppercase">{{ $h1 }}</h1>
    </div>
</section>
