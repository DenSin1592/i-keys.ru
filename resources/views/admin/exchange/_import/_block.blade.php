<div id="import-container" data-current-status="{{ $currentImportStatus }}">
    <div class="h3">Импорт:</div>
    <div id="import-status-container" class="exchange-status-container" data-update-status-url="{{ route('cc.exchange.import.status') }}">
        @include('admin.exchange._import._status')
    </div>

    <div id="import-logs" class="exchange-logs">
        @include('admin.exchange._import._logs')
    </div>
</div>