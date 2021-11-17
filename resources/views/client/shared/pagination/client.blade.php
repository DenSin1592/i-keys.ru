@if ($paginator->hasPages())
    <div class="catalog-pagination-block">
        <ul class="pagination list-unstyled d-flex flex-wrap align-items-center">

            @if (!$paginator->onFirstPage())
                <li class="page-item prev" aria-label="Previous" >
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
                        <svg class="page-media" width="18" height="18">
                            <use xlink:href="{{asset('/images/client/sprite.svg#icon-chevron-right-solid')}}"></use>
                        </svg>
                    </a>
                </li>
            @endif

                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item">...</li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page" >
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <li class="page-item next" aria-label="Next" >
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                            <svg class="page-media" width="18" height="18">
                                <use xlink:href="{{asset('/images/client/sprite.svg#icon-chevron-right-solid')}}"></use>
                            </svg>
                        </a>
                    </li>
                @endif


            <li class="page-item">
                <a class="page-link page-view-all" href="catalog.html">Смотреть все  <span class="page-badge" >{{ $paginator->total() }}</span></a>
            </li>
        </ul>
    </div>
@endif



