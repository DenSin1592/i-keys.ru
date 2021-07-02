<ul class="element-list @if (empty($lvl)) scrollable-container @endif" data-sortable-group="">
    @foreach ($typeTree as $type)
        <li data-element-id="{{ $type->id }}">
            <div class="element-container">
                @include('admin.shared.resource_list.sorting._list_controls', ['model' => $type])
                <div class="name">
                    <a href="{{ route('cc.types.show', $type->id) }}"
                       style="margin-left: {{ $lvl * 0.5 }}em;">{{ $type->name }}</a>
                </div>
                @include('admin.shared._list_flag', ['element' => $type, 'action' => route('cc.types.toggle-attribute', [$type->id, 'publish']), 'attribute' => 'publish'])
                <div class="alias">
                    {{ $type->alias }}
                </div>
                <div class="control">
                    @include('admin.types._control_block', ['type' => $type])
                </div>
            </div>
        </li>
    @endforeach
</ul>
