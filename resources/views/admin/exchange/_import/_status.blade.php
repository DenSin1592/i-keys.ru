@if(isset($importError))
    <div class="exchange-error"><b>ERROR:</b> {!! $importError !!}</div>
@endif
<div>
    <span class="title">Статус:</span>
    @if ($currentImportStatus === \App\Http\Controllers\Admin\ExchangeController::EXCHANGE_STATUS_IN_PROGRESS)
        <span class="text-success">импорт выполняется</span>
    @else
        <span>ожидание</span>
    @endif
</div>
<div>
    <span class="title">Последний обработанный файл:</span>
    {!! $importStatusData['file'] !!}
</div>
<div>
    <span class="title">Последняя обработанная строка:</span>
    {!! $importStatusData['line'] !!}
</div>
<div>
    <span class="title">Время последней обработки:</span>
    {!! isset($importStatusData['updated_at']) ? \Str::formatDate($importStatusData['updated_at'], 'd.m.Y H:i:s') : '' !!}
</div>
