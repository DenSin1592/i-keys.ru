<?php $__env->startSection('title', "Категория \"{$category->name}\""); ?>

<?php $__env->startSection('content'); ?>
    <?php if(isset($breadcrumbs)): ?>
        <?php echo $__env->make('admin.shared._catalog_breadcrumbs', ['breadcrumbs' => $breadcrumbs, 'category' => $category], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <div class="category scrollable-container">
        <strong id="subcategories">Подкатегории для категории "<?php echo e($category->name); ?>"</strong>
        <?php echo $__env->make('admin.categories._category_list_wrapper', ['disableScrollable' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <hr>

        <strong id="types">Типы товаров для категории "<?php echo e($category->name); ?>"</strong>
        <?php echo $__env->make('admin.types._type_list_wrapper', ['type' => null, 'disableScrollable' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/categories/show.blade.php ENDPATH**/ ?>