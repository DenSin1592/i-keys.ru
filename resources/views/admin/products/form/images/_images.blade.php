<fieldset class="bordered-group">
    <legend>Изображения</legend>

    <ul class="grouped-field-list product-image-list" data-element-list="container" id="image-elements">
        @forelse ($formData['images'] as $imageKey => $image)
            @include('admin.products.form.images._image')
        @empty
            <div class="form-group">
                <i>Изображения не загружены</i>
            </div>
        @endforelse
    </ul>

    <span class="btn btn-default btn-xs grouped-field-list-add"
          data-element-list="add"
          data-element-list-target="#image-elements"
          data-load-element-url="{{ route('cc.products.images.create', $category->id) }}">Добавить изображение</span>
</fieldset>
