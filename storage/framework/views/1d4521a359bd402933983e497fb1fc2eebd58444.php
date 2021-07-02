

<a class="glyphicon glyphicon-pencil"
   title="<?php echo e(trans('interactions.edit')); ?>"
   href="<?php echo e(route('cc.categories.edit', $category->id)); ?>"></a>
<a class="glyphicon glyphicon-trash"
   title="<?php echo e(trans('interactions.delete')); ?>"
   data-method="delete"
   data-confirm="Вы уверены, что хотите удалить данную категорию?"
   href="<?php echo e(route('cc.categories.destroy', [$category->id])); ?>"></a>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/categories/_control_block.blade.php ENDPATH**/ ?>