<ul class="element-list scrollable-container" data-sortable-group="">
    @foreach ($serviceList as $service)
        <li data-element-id="{{ $service->id }}">
            <div class="element-container">
                @include('admin.shared.resource_list.sorting._list_controls', ['model' => $service])
                <div class="name">
                    <a href="{{ route('cc.services.edit', [$service->id]) }}">{{ $service->name }}</a>
                </div>

                <div class="control">
                    <a class="glyphicon glyphicon-pencil"
                       title="{{ trans('interactions.edit') }}"
                       href="{{ route('cc.services.edit', [$service->id]) }}"></a>
                    <a class="glyphicon glyphicon-trash"
                       title="{{ trans('interactions.delete') }}"
                       data-method="delete"
                       data-confirm="Вы уверены, что хотите удалить данную услугу?"
                       href="{{ route('cc.services.destroy', [$service->id]) }}"></a>
                </div>

            </div>
        </li>
    @endforeach
</ul>
