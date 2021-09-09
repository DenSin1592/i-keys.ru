<div class="title">Логи импорта за последние {!! $importLogsDaysLimit !!} {!! Lang::choice('день|дня|дней', $importLogsDaysLimit) !!}
    @if($importLogs->total() > 0) ({!! $importLogs->total() !!}) @endif
    <a href="{{ route('cc.exchange.import.logs') }}" class="logs-refresh"
       style="display:none;" data-logs-refresh>обновить</a>
</div>
@if($importLogs->total() > 0)
<div class="element-list-wrapper">
    <div class="element-container header-container">
        <div class="type">Тип</div>
        <div class="file_name">Файл</div>
        <div class="line_number">Строка</div>
        <div class="message">Описание</div>
        <div class="created_at">Дата</div>
    </div>

    <div>
        <ul class="element-list scrollable-container">
            @foreach ($importLogs as $log)
                <li>
                    <div class="element-container {{ $log->type == \App\Models\ExchangeLog::TYPE_ERROR ? 'exchange-error' : '' }}">
                        <div class="type">{!! trans("validation.model_attributes.exchange.type.{$log->type}") !!}</div>
                        <div class="file_name">{!! $log->file_name !!}</div>
                        <div class="line_number">{!! $log->line_number !!}</div>
                        <div class="message">{!! $log->message !!}</div>
                        <div class="created_at">{!! \Helper::outDatetime($log->created_at) !!}</div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@include('admin.exchange._logs_pagination', ['paginator' => $importLogs])
@else
    Логи с ошибками отсутствуют.
@endif