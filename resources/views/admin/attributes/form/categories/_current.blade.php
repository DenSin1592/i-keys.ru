<ol>
    @foreach ($categories as $key => $category)
        <li data-element-container="element">
            <input data-element="id" type="hidden" name="categories[{{ $key }}][id]" value="{{ $category->id }}" />
            <a data-element="name" href="{{ route('cc.categories.edit', [$category->id]) }}" target="_blank">{{ $category->name }}</a>
        </li>
    @endforeach
</ol>