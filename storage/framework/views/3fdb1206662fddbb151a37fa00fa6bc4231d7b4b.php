<?php if(isset($breadcrumbs) && $breadcrumbs->length() > 0): ?>
    <nav aria-label="breadcrumb" id="breadcrumbs">
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?php echo e(route('home')); ?>">
                    <i class="icon-home"></i>
                    Главная
                </a>
            </li>
            <?php $__currentLoopData = $breadcrumbs->getBreadcrumbs(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('client.shared.breadcrumbs._item', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </nav>
<?php endif; ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/shared/breadcrumbs/_breadcrumbs.blade.php ENDPATH**/ ?>