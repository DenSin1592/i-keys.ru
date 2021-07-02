<div class="modal fade" id="modalReview" tabindex="-1" role="dialog" aria-labelledby="modalReviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="modalReviewLabel">Оставить отзыв</div>
                <div class="modal-subtitle"></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="<?php echo e(route('reviews')); ?>" method="POST" class="form-modal">

                    <fieldset>
                        <?php if(!empty($product)): ?>
                            <input name="product_id" type="hidden" value="<?php echo e($product->id); ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label class="form-label">Оценка:</label>

                            <div class="rating-box rating-box-lg">
                                <div class="rating" data-score="5"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="formReviewName" class="form-label">Ваше имя:</label>
                            <input name="name" type="text" id="formReviewName" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="formReviewEmail" class="form-label">E-mail:</label>
                            <input name="email" type="text" id="formReviewEmail" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="formReviewContent" class="form-label">Текст отзыва:</label>
                            <textarea name="content" id="formReviewContent" class="form-control" rows="3"></textarea>

                        </div>

                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input name="target" type="hidden" value=""/>
                                <input class="form-check-input" type="checkbox" name="privacy" id="formReviewPrivacy" checked="checked" />
                                <label class="form-check-label" for="formReviewPrivacy">Я ознакомлен и согласен с&nbsp;<a href="<?php echo e(route('privacy')); ?>" target="_blank" rel="nofollow">Политикой конфиденциальности</a></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-sm">Оставить отзыв</button>
                        </div>

                    </fieldset>

                </form>

            </div>
        </div>
    </div>
</div>



<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/layouts/modals/_review.blade.php ENDPATH**/ ?>