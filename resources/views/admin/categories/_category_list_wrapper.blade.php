<div class="element-list-wrapper category-list" data-sortable-wrapper="">
    <div class="element-container header-container">
        @include('admin.shared.resource_list.sorting._list_header')
        <div class="name">{{ trans('validation.attributes.name') }}</div>
        <div class="publish-status">{{ trans('validation.attributes.publish') }}</div>
        <div class="alias">{{ trans('validation.attributes.alias') }}</div>
        <div class="control">{{ trans('interactions.controls') }}</div>
    </div>

    <div data-sortable-container="">
        @include('admin.categories._category_list', ['categoryTree' => $categoryTree, 'lvl' => 0])
    </div>

    @include('admin.shared.resource_list.sorting._commit', ['updateUrl' => route('cc.categories.update-positions'), 'reloadUrl' => route('cc.categories.reload-list', empty($category) ? [] : [$category->id])])

    <div>
        <a href="{{ route('cc.categories.create', !empty($category) ? $category->id : null) }}" class="btn btn-success btn-xs">Добавить категорию</a>
        <div class="total-count"><strong>Общее число категорий</strong>: <div>{{ count($categoryTree) }}</div></div>
    </div>
</div>
