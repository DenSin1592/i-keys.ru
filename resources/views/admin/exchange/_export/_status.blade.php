@if(isset($exportError))
    <div class="exchange-error"><b>ERROR:</b> {!! $exportError !!}</div>
@endif
<div>
    <span class="title">Статус:</span>
    @if ($currentExportStatus === \App\Http\Controllers\Admin\ExchangeController::EXCHANGE_STATUS_IN_PROGRESS)
        <span class="text-success">экспорт выполняется</span>
    @else
        <span>ожидание</span>
    @endif
</div>
<div>
    <span class="title">Последний обработанный файл:</span>
    {!! $exportStatusData['file'] !!}
</div>
<div>
    <span class="title">Время последней обработки:</span>
    {!! isset($exportStatusData['updated_at']) ? \Str::formatDate($exportStatusData['updated_at'], 'd.m.Y H:i:s') : '' !!}
</div>
