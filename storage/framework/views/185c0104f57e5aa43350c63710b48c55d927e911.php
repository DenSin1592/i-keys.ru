<div class="modal fade" id="modalCallback" tabindex="-1" role="dialog" aria-labelledby="modalCallbackLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="modalCallbackLabel">Перезвоните мне</div>
                <div class="modal-subtitle">Оставьте заявку и наш менеджер перезвонит Вам в течение рабочего дня</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo e(route('feedback')); ?>" method="POST" class="form-modal">
                    <?php echo csrf_field(); ?>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="formCallbackName" class="form-label">Ваш имя</label>
                                <input name="name" type="text" id="formCallbackName" class="form-control">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="formCallbackPhone" class="form-label">Телефон</label>
                                <input name="phone" type="text" id="formCallbackPhone" class="form-control" placeholder="+7 (___) ___-__-__" data-client-phone-mask="1">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="formCallbackComment" class="form-label">Комментарий</label>
                                <textarea name="comment" id="formCallbackComment" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <div class="form-check form-check-inline">
                                    <input name="target" type="hidden"  value=""/>
                                    <input class="form-check-input" type="checkbox" name="privacy" id="formCallbackPrivacy" checked="checked" />
                                    <label class="form-check-label" for="formCallbackPrivacy">Я ознакомлен и согласен с&nbsp;<a href="<?php echo e(route('privacy')); ?>" target="_blank" rel="nofollow">Политикой конфиденциальности</a></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-sm">Перезвоните мне</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/layouts/modals/_callback.blade.php ENDPATH**/ ?>