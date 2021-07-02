<ul class="element-list scrollable-container" data-sortable-group="">
    @foreach ($productList as $product)
        <li data-element-id="{{ $product->id }}">
            <div class="element-container">
                @include('admin.shared.resource_list.sorting._list_controls', ['model' => $product])
                <div class="name">
                    <a href="{{ route('cc.products.edit', [$product->category->id, $product->id]) }}">{{ $product->name }}</a>
                </div>
                @include('admin.shared._list_flag', ['element' => $product, 'action' => route('cc.products.toggle-attribute', [$product->category->id, $product->id, 'publish']), 'attribute' => 'publish'])
                <div class="alias">
                    {{ $product->alias }}
                </div>
                <div class="control">
                    @include('admin.products._control_block', ['product' => $product])
                </div>
            </div>
        </li>
    @endforeach
</ul>
