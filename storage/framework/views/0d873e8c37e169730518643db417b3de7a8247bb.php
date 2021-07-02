<div id="contentCallback">
    <div class="content-form" >
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="CallbackLabel">Отправить сообщение</div>
                <div class="modal-subtitle">Остались вопросы? Позвоните или напишите нам сообщение, заполнив форму ниже, и наши менеджеры свяжутся с Вами.</div>
            </div>
            <div class="modal-body">
                <form action="<?php echo e(route('feedback')); ?>" method="POST" class="form-modal">
                    <?php echo csrf_field(); ?>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="formContentCallbackName" class="form-label">Ваш имя</label>
                                <input name="name" type="text" id="formContentCallbackName" class="form-control">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="formContentCallbackPhone" class="form-label">Телефон</label>
                                <input name="phone" type="text" id="formContentCallbackPhone" class="form-control" placeholder="+7 (___) ___-__-__" data-client-phone-mask="1">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="formContentCallbackComment" class="form-label">Комментарий</label>
                                <textarea name="comment" id="formContentCallbackComment" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <div class="form-check form-check-inline">
                                    <input name="target" type="hidden"  value=""/>
                                    <input class="form-check-input" type="checkbox" name="privacy" id="formContentCallbackPrivacy" checked="checked" />
                                    <label class="form-check-label" for="formContentCallbackPrivacy">Я ознакомлен и согласен с&nbsp;<a href="<?php echo e(route('privacy')); ?>" target="_blank" rel="nofollow">Политикой конфиденциальности</a></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-sm">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/form/callback/_callback.blade.php ENDPATH**/ ?>