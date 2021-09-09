<div class="title">Логи экспорта за последние {!! $exportLogsDaysLimit !!} {!! Lang::choice('день|дня|дней', $exportLogsDaysLimit) !!}
    @if($exportLogs->total() > 0) ({!! $exportLogs->total() !!}) @endif
    <a href="{{ route('cc.exchange.export.logs') }}" class="logs-refresh"
       style="display:none;" data-logs-refresh>обновить</a>
</div>
@if($exportLogs->total() > 0)
<div class="element-list-wrapper">
    <div class="element-container header-container">
        <div class="type">Тип</div>
        <div class="message">Описание</div>
        <div class="created_at">Дата</div>
    </div>

    <div>
        <ul class="element-list scrollable-container">
            @foreach ($exportLogs as $log)
                <li>
                    <div class="element-container {{ $log->type == \App\Models\ExchangeLog::TYPE_ERROR ? 'exchange-error' : '' }}">
                        <div class="type">{!! trans("validation.model_attributes.exchange.type.{$log->type}") !!}</div>
                        <div class="message">{!! $log->message !!}</div>
                        <div class="created_at">{!! \Helper::outDatetime($log->created_at) !!}</div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@include('admin.exchange._logs_pagination', ['paginator' => $exportLogs])
@else
    Логи с ошибками отсутствуют.
@endif