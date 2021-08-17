<ul class="element-list @if (empty($lvl)) scrollable-container @endif" data-sortable-group="">
    @foreach ($categoryTree as $category)
        <li data-element-id="{{ $category->id }}">
            <div class="element-container">
                @include('admin.shared.resource_list.sorting._list_controls', ['model' => $category])
                <div class="name">
                    <a href="{{ route('cc.products.index', $category->id) }}"
                       style="margin-left: {{ $lvl * 0.5 }}em;">{{ $category->name }}</a>
                </div>
                @include('admin.shared._list_flag', ['element' => $category, 'action' => route('cc.categories.toggle-attribute', [$category->id, 'publish']), 'attribute' => 'publish'])
                @include('admin.shared._list_flag', ['element' => $category, 'action' => route('cc.categories.toggle-attribute', [$category->id, 'menu_top']), 'attribute' => 'menu_top'])
                <div class="alias">
                    {{ $category->alias }}
                </div>
                <div class="control">
                    @include('admin.categories._control_block', ['category' => $category])
                </div>
            </div>
            @if (count($category->children) > 0)
                @include('admin.categories._category_list', ['categoryTree' => $category->children, 'lvl' => $lvl + 3])
            @endif
        </li>
    @endforeach
</ul>
