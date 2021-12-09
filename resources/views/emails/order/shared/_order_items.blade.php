<table style="
    border: 1px solid #ddd;
    width: 950px;
    border-collapse: collapse;
    border-spacing: 0;
    box-sizing: border-box;
    font-size: 14px;
    ">
    <thead>
    <tr>
        <th style="border: 1px solid #ddd; padding: 0.3em; text-align: left; font-size: 12px; width: 10%;">Код товара</th>
        <th style="border: 1px solid #ddd; padding: 0.3em; text-align: left; font-size: 12px; width: 40%;">Товар</th>
        <th style="border: 1px solid #ddd; padding: 0.3em; text-align: right; font-size: 12px; width: 15%;">Кол-во</th>
        <th style="border: 1px solid #ddd; padding: 0.3em; text-align: right; font-size: 12px; width: 15%;">Цена за единицу</th>
        <th style="border: 1px solid #ddd; padding: 0.3em; text-align: right; font-size: 12px; width: 20%;">Общая стоимость</th>
    </tr>
    </thead>
    @foreach ($order->items()->with(['product.category'])->get() as $key => $orderItem)
        <tbody>
        <tr>
            <td style="padding: 0.3em; text-align: left; vertical-align: middle; border: 1px solid #ddd; white-space: nowrap;">
                {!! $orderItem->code_1c !!}
            </td>
            <td style="padding: 0.3em; text-align: left; vertical-align: middle; border: 1px solid #ddd; ">
                @if(!is_null($orderItem->product) && $orderItem->product->publish && $orderItem->product->category->in_tree_publish)
                    <a href="{{ \UrlBuilder::getUrl($orderItem->product) }}" target="_blank">{!! $orderItem->name !!}</a>
                @else
                    {!! $orderItem->name !!}
                @endif
            </td>
            <td style="padding: 0.3em; text-align: right; vertical-align: middle; border: 1px solid #ddd; white-space: nowrap;">
                {{ $orderItem->count }}
            </td>
            <td style="padding: 0.3em; text-align: right; vertical-align: middle; border: 1px solid #ddd; white-space: nowrap;">
                {{ Str::formatDecimal($orderItem->price, ',', ' ', false) }}
            </td>
            <td style="padding: 0.3em; text-align: right; vertical-align: middle; border: 1px solid #ddd; white-space: nowrap;">
                {{ Str::formatDecimal($orderItem->summary_price, ',', ' ', false) }} руб.
            </td>
        </tr>
        </tbody>
    @endforeach
    <tbody>
    <tr>
        <td colspan="4" style="
            padding: 0.3em 0.3em 0.3em 1.3em;
            text-align: left;
            vertical-align: middle;
            border: 1px solid #ddd;
            font-weight: bold;
            ">Итого:</td>
        <td style="padding: 0.3em; text-align: right; vertical-align: middle; border: 1px solid #ddd; ">
            {{ Str::formatDecimal($order->price, ',', ' ', false) }} руб.
        </td>
    </tr>
    </tbody>
</table>
