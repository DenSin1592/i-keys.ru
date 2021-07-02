<a data-product-id="<?php echo e($product->id); ?>"
   href="javascript:void(0);"
   class="product-favorites-toggle product-action  <?php if(resolve('favorites')->added($product->id)): ?> added <?php endif; ?>"
   title="<?php echo e(resolve('favorites')->added($product->id) ? trans('favorites.remove_from_favorites') : trans('favorites.add_to_favorites')); ?>">
    <i class="icon-favorite" ></i>
</a>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/shared/products/_favorites_button.blade.php ENDPATH**/ ?>