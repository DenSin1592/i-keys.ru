@if($psbankPayments->count() > 0)
    <div id="psbank-payments">
        <strong>Оплачено по ссылке в ПСБ:</strong>
        <table>
            <tr>
                <th class="rrn">RRN (id операции)</th>
                <th class="date_at">Дата оплаты</th>
                <th class="summ">Сумма, руб</th>
            </tr>
            @foreach($psbankPayments as $psbankPayment)
                <tr>
                    <td class="rrn">{{ $psbankPayment->rrn }}</td>
                    <td class="date_at">
                        {{ isset($psbankPayment->date_at) ? $psbankPayment->date_at->format('d.m.Y H:i') : '-' }}
                    </td>
                    <td class="summ">{{ Str::formatDecimal($psbankPayment->amount, ',', ' ', false) }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endif