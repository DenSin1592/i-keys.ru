<fieldset class="bordered-group">
    <legend>Фильтр</legend>
    <div class="product-filter" data-url="<?php echo e(route('cc.types.products.filter')); ?>">
        <?php echo $__env->make('admin.types.filter._filter', ['filterVariants' => $formData['productsData']['filterVariants']->variants()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</fieldset>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/types/filter/_filter_block.blade.php ENDPATH**/ ?>