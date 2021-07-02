<li data-element-list="element" data-element-key="<?php echo $imageKey; ?>" class="<?php echo e((old("images.{$imageKey}.full_info") == 1 || !$image->exists) ? 'show-full-info' : ''); ?>">

    <?php echo Form::hidden("images[{$imageKey}][full_info]", 0, ['data-full-info-state' => '']); ?>

    <?php echo Form::hidden("images[{$imageKey}][id]", $image->id); ?>


    <div class="short-info form-group">
        <div class="loaded-image image-thumb-wrapper">
            <?php if($image->getAttachment('image')->exists()): ?>
                <a href="<?php echo e($image->getAttachment('image')->getRelativePath()); ?>" target="_blank" data-fancybox="images">
                    <img src="<?php echo e($image->getAttachment('image')->getRelativePath('thumb')); ?>" alt="" />
                </a>
            <?php else: ?>
                <img src="/images/common/no-image/no-image-100x100.png" alt="" />
            <?php endif; ?>
        </div>
    </div>

    <div class="full-info">
        <?php echo Form::tbFormGroupOpen("images.{$imageKey}.image_file"); ?>

            <?php echo Form::tbLabel("images[{$imageKey}][image]", trans('validation.attributes.image')); ?>

            <?php if($image->getAttachment('image')->exists()): ?>
                <div class="loaded-image">
                    <a href="<?php echo e($image->getAttachment('image')->getRelativePath()); ?>" target="_blank" data-fancybox>
                        <img src="<?php echo e($image->getAttachment('image')->getRelativePath('thumb')); ?>" />
                    </a>
                </div>
            <?php endif; ?>
        <?php echo Form::tbFormGroupClose(); ?>

    </div>
</li>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/products/form/images/_image.blade.php ENDPATH**/ ?>