<ul class="element-list scrollable-container" data-sortable-group="">
    @foreach ($attributeList as $attribute)
        <li data-element-id="{{ $attribute->id }}">
            <div class="element-container">
                @include('admin.shared.resource_list.sorting._list_controls', ['model' => $attribute])
                <div class="name">
                    <a href="{{ route('cc.attributes.edit', [$attribute->id]) }}">{{ $attribute->name }}</a>
                </div>
                <div class="attribute_type">{{ $attribute->type_name }}</div>

                @include('admin.shared._list_flag', ['element' => $attribute, 'action' => route('cc.attributes.toggle-attribute', [$attribute->id, 'use_in_filter']), 'attribute' => 'use_in_filter'])
                @include('admin.shared._list_flag', ['element' => $attribute, 'action' => route('cc.attributes.toggle-attribute', [$attribute->id, 'for_admin_filter']), 'attribute' => 'for_admin_filter'])
                @include('admin.shared._list_flag', ['element' => $attribute, 'action' => route('cc.attributes.toggle-attribute', [$attribute->id, 'hidden']), 'attribute' => 'hidden'])

                <div class="control">
                    <a class="glyphicon glyphicon-pencil"
                       title="{{ trans('interactions.edit') }}"
                       href="{{ route('cc.attributes.edit', [$attribute->id]) }}"></a>
                    <a class="glyphicon glyphicon-trash"
                       title="{{ trans('interactions.delete') }}"
                       data-method="delete"
                       data-confirm="Вы уверены, что хотите удалить данный параметр?"
                       href="{{ route('cc.attributes.destroy', [$attribute->id]) }}"></a>
                </div>

            </div>
        </li>
    @endforeach
</ul>
