<?php $__env->startSection('content'); ?>
    <div class="container">
        <?php echo $__env->make('client.shared.breadcrumbs._breadcrumbs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <h1 class="mb-0"><?php echo e($h1); ?></h1>

        <?php echo $textPage->content; ?>


        <?php if(count($children) > 0): ?>
            <ul class="list-unstyled">
                <?php $__currentLoopData = $children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subNode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><a href="<?php echo e(TypeContainer::getClientUrl($subNode)); ?>"><?php echo e($subNode->name); ?></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>
        <?php echo $__env->make('client.form.callback._callback', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('client.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/text_pages/show.blade.php ENDPATH**/ ?>