<a class="glyphicon glyphicon-pencil"
   title="<?php echo e(trans('interactions.edit')); ?>"
   href="<?php echo e(route('cc.manufacturers.edit', [$manufacturer->id])); ?>"></a>

<a class="glyphicon glyphicon-trash"
   title="<?php echo e(trans('interactions.delete')); ?>"
   data-method="delete"
   data-confirm="Вы уверены, что хотите удалить данного производителя?"
   href="<?php echo e(route('cc.manufacturers.destroy', [$manufacturer->id])); ?>"></a>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/manufacturers/_list_controls.blade.php ENDPATH**/ ?>