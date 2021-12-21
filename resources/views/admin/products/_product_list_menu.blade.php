{{-- Product list list for menu --}}

<ul class="scrollable-container">
    @foreach ($productList as $product)
        <li>
            <div class="menu-element {{ (isset($currentProduct) && $currentProduct->id == $product->id) ? 'active' : ''}}">
                <div class="name">
                    <a href="{{ route('cc.products.edit', [$product->category_id, $product->id]) }}" title="{{ $product->name }}">
                        {{ $product->name }}
                    </a>
                </div>
                <div class="control">
                    @include('admin.products._control_block', ['product' => $product])
                </div>
            </div>
        </li>
    @endforeach
</ul>
