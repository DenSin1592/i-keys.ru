<ul class="element-list @if (empty($lvl)) scrollable-container @endif" data-sortable-group="">
    @foreach ($nodeTree as $node)
        <li data-element-id="{{ $node->id }}">
            <div class="element-container">
                @include('admin.shared.resource_list.sorting._list_controls', ['model' => $node])
                <div class="name">
                    <a href="{{ TypeContainer::getContentUrl($node) }}"
                       style="margin-left: {{ $lvl * 0.5 }}em;">{{ $node->name }}</a>
                </div>
                @include('admin.shared._list_flag', ['element' => $node, 'action' => route('cc.structure.toggle-attribute', [$node->id, 'publish']), 'attribute' => 'publish'])
                @include('admin.shared._list_flag', ['element' => $node, 'action' => route('cc.structure.toggle-attribute', [$node->id, 'menu_top']), 'attribute' => 'menu_top'])
                @include('admin.shared._list_flag', ['element' => $node, 'action' => route('cc.structure.toggle-attribute', [$node->id, 'menu_bottom']), 'attribute' => 'menu_bottom'])
                <div class="alias">
                    <a href="{{ TypeContainer::getClientUrl($node, true) }}" target="_blank">
                        {{ TypeContainer::getClientUrl($node, false) }}
                    </a>
                </div>
                <div class="type">
                    {{ TypeContainer::getTypeName($node->type) }}
                </div>
                <div class="control">
                    @include('admin.structure._node_control_block', ['node' => $node])
                </div>
            </div>
            @if (count($node->children) > 0)
                @include('admin.structure._node_list', ['nodeTree' => $node->children, 'lvl' => $lvl + 3])
            @endif
        </li>
    @endforeach
</ul>
