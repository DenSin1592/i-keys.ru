@if(!empty($model->content) && (!isset($paginator) || $paginator->onFirstPage()))
    <div class="display-description">
    {!! $model->content !!}
    </div>
@endif