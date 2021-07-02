<ul class="element-list @if (empty($lvl)) scrollable-container @endif" data-sortable-group="">
    @foreach ($categoryTree as $category)
        <li data-element-id="{{ $category->id }}">
            <div class="element-container">
                @include('admin.shared.resource_list.sorting._list_controls', ['model' => $category])
                <div class="name">
                    <a href="{{ route('cc.categories.show', $category->id) }}"
                       style="margin-left: {{ $lvl * 0.5 }}em;">{{ $category->name }}</a>
                </div>
                <div class="buttons">
                    <a href="{{ route('cc.categories.show', [$category->id]) }}" class="btn btn-default btn-xs">Подкатегории</a>
                    <a href="{{ route('cc.products.index', [$category->id]) }}" class="btn btn-default btn-xs">Товары</a>
                    <a href="{{ route('cc.attributes.index', [$category->id]) }}" class="btn btn-default btn-xs">Параметры</a>
                </div>
                @include('admin.shared._list_flag', ['element' => $category, 'action' => route('cc.categories.toggle-attribute', [$category->id, 'publish']), 'attribute' => 'publish'])
                <div class="alias">
                    {{ $category->alias }}
                </div>
                <div class="control">
                    @include('admin.categories._control_block', ['category' => $category])
                </div>
            </div>
        </li>
    @endforeach
</ul>
