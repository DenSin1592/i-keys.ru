<ul class="element-list @if (empty($lvl)) scrollable-container @endif">
    @foreach ($orderList as $order)
        <li data-element-id="{{ $order->id }}">
            <div class="element-container">
                <div class="id">{!! $order->id !!}</div>
                <div class="status">
                    <span @if ($order->status == \App\Models\Order\StatusConstants::NOVEL)
                          class="text-success" @endif >
                        {!! trans('validation.model_attributes.order.status.' . $order->status) !!}
                    </span>
                </div>
                <div class="type">
                    {!! trans('validation.model_attributes.order.type.' . $order->type) !!}
                </div>
                <div class="payment_status">
                   <span @if ($order->payment_status == \App\Models\Order\PaymentStatusConstants::PAID)
                         class="text-success" @endif>{!! trans('validation.model_attributes.order.payment_status.' . $order->payment_status) !!}</span>
                </div>
                @include('admin.shared.device_type._list_column', ['model' => $order])
                <div class="name">
                    <a href="{{ route('cc.orders.edit', $order->id) }}">{!! $order->name ?? '<i>не указано</i>' !!}</a>
                </div>
                <div class="phone">{{ $order->phone }}</div>
                <div class="created_at">{{ $order->created_at->format('d.m.Y H:i') }}</div>

                <div class="control">
                    @include('admin.orders._control_block', ['order' => $order])
                </div>
            </div>
        </li>
    @endforeach
</ul>
