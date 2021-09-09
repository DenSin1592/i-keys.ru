@if ($paginator instanceof Illuminate\Pagination\LengthAwarePaginator)
    <div class="pagination-container">
    {!! $paginator->links() !!}
    </div>
@endif