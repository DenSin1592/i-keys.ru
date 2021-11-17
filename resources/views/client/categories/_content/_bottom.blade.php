@if(!empty($model->bottom_content) && (!isset($paginator) || $paginator->onFirstPage()))
    <div class="catalog-about-block catalog-about-bottom-block">
        {!! $model->bottom_content !!}
    </div>
@endif
