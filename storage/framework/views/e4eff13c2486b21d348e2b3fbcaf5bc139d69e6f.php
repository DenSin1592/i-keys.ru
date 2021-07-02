<?php $__env->startSection('buttons'); ?>
    <div class="buttons">
        <a href="<?php echo e(route('cc.products.index', [$category->id])); ?>" class="btn btn-default btn-xs <?php echo e(URL::current() === route('cc.products.index', [$category->id]) ? 'active' : ''); ?>">Товары</a>
        <a href="<?php echo e(route('cc.attributes.index', [$category->id])); ?>" class="btn btn-default btn-xs <?php echo e(URL::current() === route('cc.attributes.index', [$category->id]) ? 'active' : ''); ?>" >Параметры</a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts._breadcrumbs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/shared/_catalog_breadcrumbs.blade.php ENDPATH**/ ?>