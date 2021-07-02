@if ($paginator instanceof Illuminate\Pagination\LengthAwarePaginator)
    <div class="pagination-container">
        <label class="pagination-limit">
            Элементов на странице:
            <select class="choose-on-page form-control" id="switch-pagination-limit">
                @foreach (app('flex-paginator.available_limits') as $limit)
                    <option {{ $paginator->perPage() == $limit ? 'selected="selected"' : '' }} value="{{{ $paginator->path() . '?' . Arr::query([$paginator->getPageName() => 1, 'limit' => $limit]) }}}">{{{ $limit }}}</option>
                @endforeach
            </select>
        </label>
        {!! $paginator->links() !!}
    </div>
@endif
