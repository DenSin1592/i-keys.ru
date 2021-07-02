

<a class="glyphicon glyphicon-pencil"
   title="<?php echo e(trans('interactions.edit')); ?>"
   href="<?php echo e(TypeContainer::getContentUrl($node)); ?>"></a>
<a class="glyphicon glyphicon-wrench"
   title="<?php echo e(trans('interactions.properties')); ?>"
   href="<?php echo e(route('cc.structure.edit', [$node->id])); ?>"></a>
<a class="glyphicon glyphicon-trash"
   title="<?php echo e(trans('interactions.delete')); ?>"
   data-method="delete"
   data-confirm="Вы уверены, что хотите удалить данную страницу?"
   href="<?php echo e(route('cc.structure.destroy', [$node->id])); ?>"></a>
<?php /**PATH /home/kristinayudina/works/l-keys.ru_2021/www/resources/views/admin/structure/_node_control_block.blade.php ENDPATH**/ ?>