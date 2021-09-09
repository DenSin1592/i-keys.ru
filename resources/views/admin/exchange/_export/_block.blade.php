<div id="export-container" data-current-status="{{ $currentExportStatus }}">
    <div class="h3">Экспорт:</div>
    <div id="export-status-container" class="exchange-status-container" data-update-status-url="{{ route('cc.exchange.export.status') }}">
        @include('admin.exchange._export._status')
    </div>

    <div id="export-logs" class="exchange-logs">
        @include('admin.exchange._export._logs')
    </div>
</div>