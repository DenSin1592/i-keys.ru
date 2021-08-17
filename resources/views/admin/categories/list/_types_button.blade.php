<a href="{{ route('cc.categories.show', [$category->id]) . '#types' }}" class="btn btn-default btn-xs types">
    Типы{{--
    --}}@if ($category->total_types_count){{--
        --}}: {{--
        --}}<span class="count" title="Количество дочерних типов">{{ $category->child_types_count }}</span>{{--
        --}} / {{--
        --}}<span class="count" title="Общее количество всех вложенных типов">{{ $category->total_types_count }}</span>{{--
    --}}@endif
</a>
