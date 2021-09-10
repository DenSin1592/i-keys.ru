<table>
    @foreach($products as $product)
        <tr data-element-list="element" data-product-id="{{ $product->id }}">
            <td class="name">
                <a target="_blank" class="order-item-product-link" href="{{ route('cc.products.edit', [$product->category->id, $product->id]) }}">
                    {{ $product->name_with_code_1c }}
                </a>
                <input type="hidden" value="{{ $product->name }}">
            </td>
            <td class="count">
                <input data-count="" type="text" class="form-control" data-positive-integer="" value="1">
            </td>
            <td class="add">
                <button type="button" class="btn btn-xs btn-success add" aria-label="add"
                        data-item-type="product"
                        data-url="{{ route('cc.orders.items.products.add', [$product->id]) }}"
                        data-method="post"
                        >
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </button>
            </td>
        </tr>
    @endforeach
</table>
