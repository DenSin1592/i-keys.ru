<fieldset class="bordered-group">
    <legend>Видеообзоры</legend>
    <?php if($formData['product']->shopGroup): ?>
        <div class="alert alert-info">
            Список видеообзоров является сквозным для всех товаров этой группы, т.е. при редактировании этого списка он
            изменится для всех товаров, входящих в эту группу.</i>
        </div>
    <?php endif; ?>

    <ul class="grouped-field-list product-image-list" data-element-list="container" id="video-review-elements">
        <?php $__empty_1 = true; $__currentLoopData = $formData['videoReviews']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $videoReviewKey => $videoReview): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php echo $__env->make('admin.products.form.video_reviews._video_review', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="form-group">
                <i>Видеообзоры не загружены</i>
            </div>
        <?php endif; ?>
    </ul>

    <span class="btn btn-default btn-xs grouped-field-list-add"
          data-element-list="add"
          data-element-list-target="#video-review-elements"
          data-load-element-url="<?php echo e(route('cc.products.video-reviews.create')); ?>">Добавить видеообзор</span>
</fieldset>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/products/form/video_reviews/_video_reviews.blade.php ENDPATH**/ ?>