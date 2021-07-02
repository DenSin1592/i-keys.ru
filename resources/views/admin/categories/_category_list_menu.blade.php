{{-- Category list for menu --}}

<ul class="@if($lvl == 0) scrollable-container @endif">
    @foreach ($categoryTree as $category)
        <li>
            <div class="menu-element {{ (isset($currentCategory) && $currentCategory->id == $category['element']->id) ? 'active' : ''}}">
                <div class="name">
                    <a href="{{ route('cc.products.index', $category['element']->id) }}"
                       style="margin-left: {{ $lvl * 0.5 }}em;"
                       class="arrowed"
                       title="{{ $category['element']->name }}">
                        @if ($category['hasChildren'])
                            @if (count($category['children']) > 0)
                                <span class="menu-arrow glyphicon glyphicon-triangle-bottom"></span>
                            @else
                                <span class="menu-arrow glyphicon glyphicon-triangle-right"></span>
                            @endif
                        @else
                            <span class="menu-arrow"></span>
                        @endif
                        {{ $category['element']->name }}
                    </a>
                </div>
                <div class="control">
                    @include('admin.categories._control_block', ['category' => $category['element']])
                </div>
            </div>
            @if (count($category['children']) > 0)
                @include('admin.categories._category_list_menu', ['categoryTree' => $category['children'], 'lvl' => $lvl + 3, 'currentCategory' => isset($currentCategory) ? $currentCategory : null])
            @endif
        </li>
    @endforeach
</ul>
