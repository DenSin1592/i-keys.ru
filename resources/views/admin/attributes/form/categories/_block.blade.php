<fieldset class="bordered-group">
    <legend>Категории</legend>

    <div id="modal-categories-current">
        @include('admin.attributes.form.categories._current', ['categories' => $formData['categories']])
    </div>

    <div class="form-group">
        <button type="button" class="btn btn-success"
                data-source="#modal-categories-current"
                data-toggle="modal" data-target="#modal-categories-editor">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            Выбрать категории для параметра
        </button>
    </div>

    <div class="modal fade modal-associations-editor"
         data-modal-associations="editor"
         tabindex="-1" role="dialog" aria-hidden="true" id="modal-categories-editor">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Выбор категорий</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="editor-block-title">Доступные категории</div>
                            <div class="editor-elements-search">
                                <input class="form-control input-sm" type="text" placeholder="Поиск" data-editor-search="available" />
                            </div>
                            <div data-editor-wait="available">Подождите...</div>
                            <div class="editor-elements-container"
                                 data-editor-container="available"
                                 data-url="{{ route('cc.attributes.categories.available') }}">
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="editor-block-title">Выбранные категории</div>
                            <div class="editor-elements-search">
                                <input class="form-control input-sm" type="text" placeholder="Поиск" data-editor-search="current" />
                            </div>
                            <div class="editor-elements-container" data-editor-container="current">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-primary"
                            data-editor-action="save"
                            data-url="{{ route('cc.attributes.categories.rebuild-current') }}">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
</fieldset>
