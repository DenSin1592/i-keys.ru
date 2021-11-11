<ul class="element-list">

    @foreach ($elements as $element)
        <li data-element-id="{{ $element->id }}">
            <div class="element-container">

                <div class="name">
                    <a href="{{ route('cc.subdomains.edit', $element->id) }}">{{ $element->city_name }}</a>
                </div>

                <div class="control">
                    @include('admin.subdomains._control_block')
                </div>
            </div>
        </li>
    @endforeach

</ul>
