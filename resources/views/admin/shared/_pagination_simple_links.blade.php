@if ($paginator instanceof Illuminate\Pagination\LengthAwarePaginator)
    <div class="pagination-container">
        {!! $paginator->links(\Illuminate\Pagination\LengthAwarePaginator::$defaultSimpleView)->render() !!}
    </div>
@endif
