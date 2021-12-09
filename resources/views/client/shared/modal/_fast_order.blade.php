<div class="modal fade" id="modalQuickOrder" tabindex="-1" aria-labelledby="modalQuickOrderLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title title-h3 font-family-secondary" id="modalQuickOrderLabel">Быстрый заказ</h3>

                <button type="button" class="modal-close close" data-dismiss="modal" aria-label="Close">
                    <svg class="close-media" width="24" height="24">
                        <use xlink:href="/images/sprite.svg#icon-close"></use>
                    </svg>
                </button>
            </div>

            <div class="modal-body">
                <form action="POST" data-method="POST" data-action="{{route('order.fast.store')}}"
                      class="form-modal form" id="quick-order">

                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="form-quick-order-name"
                               placeholder="Имя">
                    </div>

                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="form-quick-order-email"
                               placeholder="Почта *" required>
                    </div>

                    <div class="form-group">
                        <input type="tel" class="form-control" name="phone" id="form-quick-order-phone"
                               placeholder="Телефон *" required>
                    </div>

                    <button type="submit" class="btn btn-lg">Отправить</button>
                </form>
            </div>
        </div>
    </div>
</div>
