@if(count($listTypeProducts ?? []))
<div class="catalog-tags-block">
    <ul class="catalog-tags-list list-unstyled d-flex flex-wrap">

        @foreach($listTypeProducts as $name => $url)
        <li class="catalog-tag-item">
            <a href="{{$url}}" class="catalog-tag-link">{{$name}}</a>
        </li>
        @endforeach

    </ul>
</div>
@endif
