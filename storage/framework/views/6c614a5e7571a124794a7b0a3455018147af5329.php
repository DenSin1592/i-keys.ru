<div class="modal fade"
     data-toggle-url="<?php echo e(route('compare.toggle')); ?>" data-remove-url="<?php echo e(route('compare.remove')); ?>"
     id="modalProductCompare" tabindex="-1" role="dialog" aria-labelledby="modalProductCompareLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-header-content">
                    <div class="modal-title" data-compare-modal="title"
                         data-default-title="Ваш товар добавлен к сравнению"></div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="icon-close" ></i>
                    </button>
                </div>
            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <div data-compare-modal="content"></div>
                    <div data-compare-modal="wait" class="modal-wait">Пожалуйста, подождите...</div>
                </div>
            </div>

            <div class="modal-footer" data-compare-modal="footer"></div>
        </div>
    </div>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/layouts/modals/_compare.blade.php ENDPATH**/ ?>