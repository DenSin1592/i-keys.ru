<div class="form-group">

    <div class="{{ $errors->has('order_items') ? 'has-error' : '' }}">
        <label class="control-label">{{ trans('validation.attributes.order_items') }}</label>
        @if ($errors->has('order_items'))
            <div class="validation-errors">
                @foreach ($errors->get('order_items') as $errorMessage)
                    {{ $errorMessage }}<br/>
                @endforeach
            </div>
        @endif
    </div>

    <table class="table table-bordered order-items">
        <thead>
        <tr>
            <th>{{ trans('validation.attributes.name') }}</th>
            <th class="code-1c">{{ trans('validation.attributes.code_1c') }}</th>
            <th class="count">{{ trans('validation.attributes.count') }}, шт.</th>
            <th class="price">{{ trans('validation.attributes.price') }}, руб.</th>
            <th class="sum">{{ trans('validation.attributes.sum') }}, руб.</th>
            <th>Удалить</th>
        </tr>
        </thead>
        <tbody id="order-items-container"
               data-url="{{ route('cc.orders.items.refresh-prices') }}"
               data-method="post">

        @include('admin.orders.form.order_items._order_item_list', ['orderItems' => $orderItems])

        </tbody>
        <tbody id="total-price-container">
        <tr>
            <td colspan="4" class="sum-title">Итого:</td>
            <td class="sum" data-price="total">
                @include('admin.orders.form.order_items._total_price', ['totalPrice' => $totalPrice])
            </td>
            <td></td>
        </tr>
        </tbody>
    </table>
</div>

@include('admin.orders.form.order_items._popup._order_item_list', ['order' => $order])
