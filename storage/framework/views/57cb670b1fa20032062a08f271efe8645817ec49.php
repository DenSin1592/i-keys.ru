<a href="<?php echo e(route('cc.categories.show', [$category->id])); ?>" class="btn btn-default btn-xs categories">
    Подкатегории<?php if($category->total_categories_count): ?>: <span class="count" title="Количество дочерних категорий"><?php echo e($category->child_categories_count); ?></span> / <span class="count" title="Общее количество всех вложенных категорий"><?php echo e($category->total_categories_count); ?></span><?php endif; ?>
</a>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/categories/list/_categories_button.blade.php ENDPATH**/ ?>