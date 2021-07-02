<a href="<?php echo e(route('cc.types.show', [$category->id, $type->id])); ?>" class="btn btn-default btn-xs types">
    Типы<?php if($type->total_types_count): ?>: <span class="count" title="Количество дочерних типов"><?php echo e($type->child_types_count); ?></span> / <span class="count" title="Общее количество всех вложенных типов"><?php echo e($type->total_types_count); ?></span><?php endif; ?>
</a>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/types/list/_types_button.blade.php ENDPATH**/ ?>