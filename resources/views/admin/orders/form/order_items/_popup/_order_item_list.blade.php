{{-- Button trigger popup window --}}
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#popup-order-items"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;&nbsp;Добавить товары/услуги</button>

{{-- Popup window --}}
<div class="modal fade" id="popup-order-items" tabindex="-1" role="dialog" aria-labelledby="orderItemsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="left-column">
                    <div class="element-list-wrapper">
                        <div>
                            <h4>Добавить товары</h4>
                            <div id="category-tree-container" class="element-list-wrapper" data-url="{{ route('cc.orders.items.load-category-tree') }}">
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="element-list-wrapper">
                        <div>
                            <h5 class="toggleable" data-action="get-service" data-item-type="other" data-url="{{ route('cc.orders.items.services.new') }}" data-method="get">
                                Добавить услугу
                            </h5>
                        </div>
                    </div>
                </div>

                <div class="right-column">
                    <div data-element-list="header">
                        <table style="width: 97.5%">
                            <tbody>
                                <tr>
                                    <th class="name">Название</th>
                                    <th class="count">Кол-во</th>
                                    <th class="add"></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div data-element-list="available"></div>
                    <hr>
                    <div data-element-list="selected"></div>
                </div>
                <div style="clear:both;"></div>
            </div>
            <div class="modal-footer">
                <img class="save-wait" style="display: none;" src="{{ Asset::timed('/images/common/ajax-loader/small_black.gif') }}">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary save"
                        data-url="{{ route('cc.orders.items.save') }}"
                        data-method="post"
                        >Сохранить</button>
            </div>
        </div>
    </div>
</div>

<br><br>
