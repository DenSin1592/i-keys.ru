<div class="modal fade"
     data-toggle-url="<?php echo e(route('favorites.toggle')); ?>" data-remove-url="<?php echo e(route('favorites.remove')); ?>"
     id="modalProductFavorites" tabindex="-1" role="dialog" aria-labelledby="modalProductFavoritesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-header-content">
                    <div class="modal-title" data-favorites-modal="title"
                         data-default-title="Ваш товар добавлен в избранное"></div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <div data-favorites-modal="content"></div>
                    <div data-favorites-modal="wait" class="modal-wait">Пожалуйста, подождите...</div>
                </div>
            </div>

            <div class="modal-footer" data-favorites-modal="footer"></div>
        </div>
    </div>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/layouts/modals/_favorites.blade.php ENDPATH**/ ?>