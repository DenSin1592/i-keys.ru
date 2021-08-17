<a href="{{ route('cc.categories.show', [$category->id]) }}" class="btn btn-default btn-xs categories">
    Подкатегории{{--
    --}}@if ($category->total_categories_count){{--
        --}}: {{--
        --}}<span class="count" title="Количество дочерних категорий">{{ $category->child_categories_count }}</span>{{--
        --}} / {{--
        --}}<span class="count" title="Общее количество всех вложенных категорий">{{ $category->total_categories_count }}</span>{{--
    --}}@endif
</a>
