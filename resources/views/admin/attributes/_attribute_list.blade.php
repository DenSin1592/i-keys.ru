<ul class="element-list scrollable-container" data-sortable-group="">
    @foreach ($attributeList as $attribute)
        <li data-element-id="{{ $attribute->id }}">
            <div class="element-container">
                @include('admin.shared.resource_list.sorting._list_controls', ['model' => $attribute])

                <div class="name">
                    <a href="{{ route('cc.attributes.edit', [$category->id, $attribute->id]) }}">{{ $attribute->name }}</a>
                </div>

                <div class="control">
                    <a class="glyphicon glyphicon-pencil"
                       title="{{ trans('interactions.edit') }}"
                       href="{{ route('cc.attributes.edit', [$category->id, $attribute->id]) }}"></a>
                    <a class="glyphicon glyphicon-trash"
                       title="{{ trans('interactions.delete') }}"
                       data-method="delete"
                       data-confirm="Вы уверены, что хотите удалить данный параметр?"
                       href="{{ route('cc.attributes.destroy', [$category->id, $attribute->id]) }}"></a>
                </div>

            </div>
        </li>
    @endforeach
</ul>
