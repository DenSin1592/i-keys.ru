<div class="modal fade" id="modalAddKeys" tabindex="-1" aria-labelledby="modalAddKeysLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title title-h3 font-family-secondary" id="modalAddKeysLabel">Добавить ключи</h3>
                <div class="modal-subtitle">В комплекте с замком идет 3 бесплатных ключа. Если Ваша семья больше, можете доукомплектовать замок дополнительными ключами.</div>

                <button type="button" class="modal-close close" data-dismiss="modal" aria-label="Close">
                    <svg class="close-media" width="24" height="24">
                        <use xlink:href="images/sprite.svg#icon-close"></use>
                    </svg>
                </button>
            </div>

            <div class="modal-body">
                <form action="" class="form-modal">
                    <div class="row">
                        <div class="col-auto">
                            <div class="form-group m-xxl-0">
                                <span class="form-label" >Стоимость одно ключа</span>
                                <div class="modal-price font-family-secondary">280 руб.</div>
                            </div>
                        </div>

                        <div class="col-auto">
                            <div class="form-group m-xxl-0">
                                <label for="modalAddKeysQuantity" class="form-label">Кол-во</label>

                                <div class="custom-number custom-control d-flex align-items-center">
                                    <button type="button" class="custom-number-button custom-number-decrease d-flex align-items-center justify-content-center">
                                        <svg class="custom-number-button-media" width="12" height="12">
                                            <use xlink:href="images/sprite.svg#icon-minus"></use>
                                        </svg>
                                    </button>

                                    <input type="number" id="modalAddKeysQuantity" class="custom-number-input" value="1">

                                    <button type="button" class="custom-number-button custom-number-increase d-flex align-items-center justify-content-center">
                                        <svg class="custom-number-button-media" width="12" height="12">
                                            <use xlink:href="images/sprite.svg#icon-plus"></use>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-auto">
                            <div class="form-group m-0">
                                <button type="button" class="modal-control btn btn-lg" data-dismiss="modal" aria-label="Close">Добавить</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
