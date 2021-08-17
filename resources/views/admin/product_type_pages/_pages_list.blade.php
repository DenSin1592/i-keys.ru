<ul class="element-list @if (empty($lvl)) scrollable-container @endif" data-sortable-group="">
    @foreach ($productTypePageTree as $productTypePage)
        <li data-element-id="{{ $productTypePage->id }}">
            <div class="element-container">
                @include('admin.shared.resource_list.sorting._list_controls', ['model' => $productTypePage])
                <div class="name">
                    <a href="{{route('cc.product-type-pages.edit', [$productTypePage->id]) }}"
                       style="margin-left: {{ $lvl * 0.5 }}em;">{{ $productTypePage->name }}</a>
                </div>
                @include('admin.shared._list_flag', ['element' => $productTypePage, 'action' => route('cc.product-type-pages.toggle-attribute', [$productTypePage->id, 'publish']), 'attribute' => 'publish'])
                <div class="alias">
{{--                    <a href="{{\UrlBuilder::getUrl($productTypePage) }}" target="_blank">--}}
                        {{ $productTypePage->alias }}
{{--                    </a>--}}
                </div>
                <div class="control">
                    @include('admin.product_type_pages._control_block', ['productTypePage' => $productTypePage])
                </div>
            </div>
            @if (count($productTypePage->children) > 0)
                @include('admin.product_type_pages._pages_list', ['productTypePageTree' => $productTypePage->children, 'lvl' => $lvl + 3])
            @endif
        </li>
    @endforeach
</ul>
