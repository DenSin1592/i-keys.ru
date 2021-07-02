

<a class="btn btn-danger"
   data-method="delete"
   data-confirm="Вы уверены, что хотите удалить данный тип?"
   href="<?php echo e(route('cc.types.destroy', [$category->id, $type->id])); ?>"><?php echo e(trans('interactions.delete')); ?></a>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/types/_delete_type.blade.php ENDPATH**/ ?>