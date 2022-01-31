@if(!empty($bottomContent) && (!isset($paginator) || $paginator->onFirstPage()))
    <div class="catalog-about-block catalog-about-bottom-block">
        {!! $bottomContent !!}
    </div>
@endif
