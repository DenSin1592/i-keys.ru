<ol>
    @foreach ($models as $key => $model)
        <li data-element-container="element">
            <input data-element="id" type="hidden" name="{{$relationsName}}[{{{ $key }}}][id]" value="{{{ $model->id }}}" />
            <a data-element="name"

               @if($model instanceof App\Models\Product)
               href="{{{route($routeEdit, [$model->category_id, $model->id ]) }}}"
               @else
               href="{{{route($routeEdit, [$model->id ]) }}}"
               @endif
               target="_blank">
                {{{ $model->name }}}
            </a>
        </li>
    @endforeach
</ol>
