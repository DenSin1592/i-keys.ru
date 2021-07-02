<a href="<?php echo e(route('cc.categories.show', [$category->id]) . '#types'); ?>" class="btn btn-default btn-xs types">
    Типы<?php if($category->total_types_count): ?>: <span class="count" title="Количество дочерних типов"><?php echo e($category->child_types_count); ?></span> / <span class="count" title="Общее количество всех вложенных типов"><?php echo e($category->total_types_count); ?></span><?php endif; ?>
</a>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/categories/list/_types_button.blade.php ENDPATH**/ ?>