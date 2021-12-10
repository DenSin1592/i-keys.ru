<div class="modal fade"
     id="modalRemoveInCart"
     tabindex="-1"
     role="dialog"
     aria-labelledby="modalRemoveInCartLabel"
     aria-hidden="true"
     data-url="{{route('cart.remove')}}"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title title-h3 font-family-secondary" id="modalRemoveInCartLabel">Удаление товара</h3>

                <button type="button" class="modal-close close" data-dismiss="modal" aria-label="Close">
                    <svg class="close-media" width="24" height="24">
                        <use xlink:href="{{asset('/images/client/sprite.svg#icon-close')}}"></use>
                    </svg>
                </button>
            </div>


            <div class="modal-body"><div class="modal-message text-lead"></div>

                <div class="modal-quantity">
                    Вы точно хотите удалить выбранный товар? Отменить данное действие будет невозможно.
                </div>


            </div>

            <div class="modal-footer">
                <div class="modal-controls-group form-row flex-column flex-md-row">
                    <div class="col-md-auto">
                        <a href="javascript:void(0);" class="modal-control btn btn-lg" data-card-remove>Удалить</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
