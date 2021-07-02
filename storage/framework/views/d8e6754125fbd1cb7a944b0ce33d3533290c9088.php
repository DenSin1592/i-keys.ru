

<a class="btn btn-danger"
   data-method="delete"
   data-confirm="Вы уверены, что хотите удалить данный товар?"
   href="<?php echo e(route('cc.products.destroy', [$product->category->id, $product->id])); ?>"><?php echo e(trans('interactions.delete')); ?></a>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/products/_delete_product.blade.php ENDPATH**/ ?>