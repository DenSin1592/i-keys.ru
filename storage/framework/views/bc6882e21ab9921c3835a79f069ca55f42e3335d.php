<div class="modal fade"
     data-url="<?php echo e(route('cart.add')); ?>"
     id="modalProductOrder" tabindex="-1" role="dialog" aria-labelledby="modalProductOrderLabel" aria-hidden="true" data-target="">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-header-content">
                    <div class="modal-title" data-cart-modal="title"
                         data-default-title="Ваш товар добавлен в корзину"></div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <div data-cart-modal="content"></div>
                    <div data-cart-modal="wait" class="modal-wait">Пожалуйста, подождите...</div>
                </div>
            </div>

            <div class="modal-footer" data-cart-modal="footer"></div>
        </div>
    </div>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/layouts/modals/_cart.blade.php ENDPATH**/ ?>