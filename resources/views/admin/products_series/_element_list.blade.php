<ul class="element-list @if (empty($lvl)) scrollable-container @endif">
    @foreach ($modelList as $model)
        <li data-element-id="{{ $model->id }}">
            <div class="element-container">
                <div class="id">
                    {{ $model->id }}
                </div>

                <div class="name">
                    <a href="{{ route('cc.products-.edit', $model->id) }}">{{ $model->name }}</a>
                </div>


                <div class="control">
                    @include('admin.review._control_block')
                </div>

            </div>
        </li>
    @endforeach
</ul>
