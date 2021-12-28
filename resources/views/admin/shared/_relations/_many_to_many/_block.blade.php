<fieldset class="bordered-group">
    <legend>{{$blockName}}</legend>

    <div class="field-hint-block">
        <p></p>
    </div>

    <div id="{{"modal-".$relationsName."-current"}}">
        @include('admin.shared._relations._many_to_many._current')
    </div>

    @if($terminalEnabled)
        <div class="form-group">
            <button type="button" class="btn btn-success"
                    data-source="#{{"modal-$relationsName-current"}}"
                    data-toggle="modal" data-target="#{{"modal-$relationsName-editor"}}">
                Редактировать
            </button>
        </div>

        <div class="modal fade modal-associations-editor"
             data-modal-associations="editor"
             tabindex="-1" role="dialog" aria-hidden="true" id="{{"modal-$relationsName-editor"}}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Терминал построения связей</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="editor-block-title">Доступно</div>
                                <div class="editor-elements-search">
                                    <input class="form-control input-sm" type="text" placeholder="Поиск"
                                           data-editor-search="available"/>
                                </div>
                                <div data-editor-wait="available">Подождите...</div>
                                <div class="editor-elements-container"
                                     data-editor-container="available"
                                     data-url="{{{ route($routeAvailable) }}}">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="editor-block-title">Выбранно</div>
                                <div class="editor-elements-search">
                                    <input class="form-control input-sm" type="text" placeholder="Поиск"
                                           data-editor-search="current"/>
                                </div>
                                <div class="editor-elements-container" data-editor-container="current"
                                     data-sortable="1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                        <button type="button" class="btn btn-primary"
                                data-editor-action="save"
                                data-url="{{{ route($routeRebuildCurrent) }}}">Сохранить
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</fieldset>
