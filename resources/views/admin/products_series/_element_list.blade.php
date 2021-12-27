<ul class="element-list @if (empty($lvl)) scrollable-container @endif">
    @foreach ($modelList as $model)
        <li data-element-id="{{ $model->id }}">
            <div class="element-container">
                <div class="id">
                    {{ $model->id }}
                </div>

                <div class="name">
                    <a href="{{ route('cc.products-series.edit', $model->id) }}">{{ $model->value }}</a>
                </div>

                <div class="type">Товаров: {{$model->productsForSingle->count()}}</div>
                <div class="type">{{$model->getTypeSeries()}}</div>

                <div class="control">
                    @include('admin.products_series._control_block')
                </div>

            </div>
        </li>
    @endforeach
</ul>
