

<a class="glyphicon glyphicon-pencil"
   title="<?php echo e(trans('interactions.edit')); ?>"
   href="<?php echo e(route('cc.products.edit', [$product->category->id, $product->id])); ?>"></a>
<a class="glyphicon glyphicon-trash"
   title="<?php echo e(trans('interactions.delete')); ?>"
   data-method="delete"
   data-confirm="Вы уверены, что хотите удалить данный товар?"
   href="<?php echo e(route('cc.products.destroy', [$product->category->id, $product->id])); ?>"></a>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/products/_control_block.blade.php ENDPATH**/ ?>