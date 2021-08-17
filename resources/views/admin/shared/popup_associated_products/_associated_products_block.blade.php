@php $blockTitle = $blockTitle ?? trans("validation.attributes.{$fieldGroup}");
@endphp
<fieldset class="bordered-group">
    <legend>{{ $blockTitle }}</legend>

    @if (!empty($hint))
        <p class="field-hint-block">{{ $hint }}</p>
    @endif

    <div id="associated-current-products-{{ \Helper::replaceSquareBrackets($fieldGroup, '-') }}">
        @include('admin.shared.popup_associated_products._current_products', ['fieldGroup' => $fieldGroup, 'associatedProducts' => $associatedProducts])
    </div>

    <div class="form-group">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#associated-products-editor-{{ \Helper::replaceSquareBrackets($fieldGroup, '-') }}">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            Редактирование
        </button>
    </div>

    <div class="modal fade associated-products-editor" tabindex="-1" role="dialog" aria-hidden="true"
         data-target-container="#associated-current-products-{{ \Helper::replaceSquareBrackets($fieldGroup, '-') }}"
         data-associated-products="editor" id="associated-products-editor-{{ \Helper::replaceSquareBrackets($fieldGroup, '-') }}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{ $blockTitle }} - редактирование</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-5 available-products-container"
                             data-associated-products="available-products-container"
                             data-available-products-url="{{ route('cc.associated-products.available-products', [$fieldGroup, isset($product)? $product->id : null]) }}"></div>
                        <div class="col-xs-1 arrows-container">
                            <div>
                                <span class="glyphicon glyphicon glyphicon-backward" title="Перенести все" data-associated-products="remove-all"></span>
                                &nbsp;
                                <span class="glyphicon glyphicon glyphicon-forward" title="Перенести все" data-associated-products="add-all"></span>
                            </div>
                        </div>
                        <div class="col-xs-5 current-products-container">
                            <div class="top-padding">
                                <div class="categories-list"></div>
                                <div class="form-group has-feedback filter-container">
                                    <input class="form-control filter-input" placeholder="Фильтр" type="text"
                                           autocomplete="off"
                                           data-associated-products="filter-selected"
                                           data-filter-url="{{ route('cc.associated-products.filter-selected') }}"
                                           data-product-list-filter="[data-associated-products='current-products']" />
                                    <span class="glyphicon glyphicon-search form-control-feedback apply-filter-button btn" aria-hidden="true" data-associated-products="apply-filter" data-target="[data-associated-products='filter-selected']"></span>
                                </div>
                            </div>
                            <ul class="product-list" data-associated-products="current-products" @if (!empty($disableSorting)) data-sorting="disabled" @endif></ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-primary" data-associated-products="save"
                            data-loading-text="<i class='fa fa-spinner fa-spin '></i> Идет сохранение..."
                            data-url="{{ route('cc.associated-products.new-associations', [$fieldGroup]) }}">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
</fieldset>
