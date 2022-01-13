<tr class="order-item {{ isset($changedIds) && in_array($orderItem->id, $changedIds) ? 'highlighted' : '' }}"
    data-order-item-id="{{ $orderItem->id }}"
    @if (!is_null($orderItem->product_id))
        data-product-id="{{ $orderItem->product_id }}"
    @else
        data-name="{{ $orderItem->name }}"
    @endif>

    <td class="code-1c">
        @if(!is_null($orderItem->service_id)){{'Услуга'}} @endif
        @if(!is_null($orderItem->product_id)){{'Продукт'}} @endif
    </td>

    <td class="name">
        {!! Form::hidden("order_items[{$orderItem->id}][id]", $orderItem->id) !!}

        {!! Form::tbFormGroupOpen("order_items.{$orderItem->id}.name") !!}
            {!! Form::tbText("order_items[{$orderItem->id}][name]", $orderItem->name, ['class' => 'input-sm name']) !!}
            @if (!is_null($orderItem->product))
                <a href="{{ route('cc.products.edit', [$orderItem->product->category->id, $orderItem->product->id]) }}"
                   target="_blank"
                   class="glyphicon glyphicon-share" title="Редактировать"></a>

                @if (data_get($orderItem, 'product.publish') && data_get($orderItem, 'product.category.in_tree_publish'))
{{--                <a href="{{ \UrlBuilder::getUrl(data_get($orderItem, 'product') )}}"--}}
{{--                        target="_blank" class="glyphicon glyphicon-share-alt" title="Смотреть на сайте"></a>--}}
                @endif

                {!! Form::hidden("order_items[{$orderItem->id}][product_id]", $orderItem->product_id) !!}
            @endif

        @if (!is_null($orderItem->service_id))
            <a href="{{ route('cc.services.edit', [ $orderItem->service_id]) }}"
               target="_blank"
               class="glyphicon glyphicon-share" title="Редактировать"></a>

            {!! Form::hidden("order_items[{$orderItem->id}][product_id]", $orderItem->product_id) !!}
        @endif
        {!! Form::tbFormGroupClose() !!}
    </td>

    <td class="code-1c">
        {!! Form::tbFormGroupOpen("order_items.{$orderItem->id}.code_1c") !!}
            {!! $orderItem->code_1c !!}
            {!! Form::hidden("order_items[{$orderItem->id}][code_1c]", $orderItem->code_1c) !!}
        {!! Form::tbFormGroupClose() !!}
    </td>

    <td class="count">
        {!! Form::tbFormGroupOpen("order_items.{$orderItem->id}.count") !!}
            {!! Form::tbNumber("order_items[{$orderItem->id}][count]", $orderItem->count, ['class' => 'input-sm count', 'min' => '1']) !!}
        {!! Form::tbFormGroupClose() !!}
    </td>

    <td class="price">
        {!! Form::tbFormGroupOpen("order_items.{$orderItem->id}.price") !!}
            {!! Form::tbNumber("order_items[{$orderItem->id}][price]", $orderItem->price , ['class' => 'input-sm price', 'min' => '0', 'step' => '0.01']) !!}
        {!! Form::tbFormGroupClose() !!}
    </td>

    @include('admin.orders.form.order_items._summary_price', ['summaryPrice' => $orderItem->summary_price])

    <td class="delete">
        <a class="glyphicon glyphicon-trash delete" title="Удалить"
           data-confirm="Вы уверены, что хотите удалить данный элемент?" href="#"></a>
    </td>
</tr>
