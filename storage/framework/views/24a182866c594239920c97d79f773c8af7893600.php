<a href="<?php echo e(route('cc.products.index', [$category->id])); ?>" class="btn btn-default btn-xs products">
    Товары<?php if($category->total_products_count): ?>: <span class="count" title="Количество товаров в категории"><?php echo e($category->child_products_count); ?></span> / <span class="count" title="Общее количество товаров, включая товары во всех вложенных категориях"><?php echo e($category->total_products_count); ?></span><?php endif; ?>
</a>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/categories/list/_products_button.blade.php ENDPATH**/ ?>