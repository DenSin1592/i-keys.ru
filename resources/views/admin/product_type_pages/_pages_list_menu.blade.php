<ul class="@if($lvl == 0) scrollable-container @endif">
    @foreach ($productTypePageTree as $productTypePage)
        <li>
            <div class="menu-element {{ ($currentPage->id == $productTypePage['element']->id) ? 'active' : ''}}">
                <div class="name">
                    <a href="{{ route('cc.product-type-pages.edit', [$productTypePage['element']->id]) }}"
                       style="margin-left: {{ $lvl * 0.5 }}em;"
                       class="arrowed"
                       title="{{ $productTypePage['element']->name }}">
                        @if ($productTypePage['hasChildren'])
                            @if (count($productTypePage['children']) > 0)
                                <span class="menu-arrow glyphicon glyphicon-triangle-bottom"></span>
                            @else
                                <span class="menu-arrow glyphicon glyphicon-triangle-right"></span>
                            @endif
                        @else
                            <span class="menu-arrow"></span>
                        @endif
                        {{ $productTypePage['element']->name }}
                    </a>
                </div>
                <div class="control">
                    @include('admin.product_type_pages._control_block', ['productTypePage' => $productTypePage['element']])
                </div>
            </div>
            @if (count($productTypePage['children']) > 0)
                @include('admin.product_type_pages._pages_list_menu', array('productTypePageTree' => $productTypePage['children'], 'lvl' => $lvl + 3, 'currentPage' => $currentPage))
            @endif
        </li>
    @endforeach
</ul>
