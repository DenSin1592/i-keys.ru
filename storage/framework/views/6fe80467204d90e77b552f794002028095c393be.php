<a class="product-favorites-toggle <?php if(resolve('favorites')->added($product->id)): ?> added <?php endif; ?> product-action d-inline-flex align-items-center justify-content-center nowrap" href="javascript:void(0);"
   data-product-id="<?php echo e($product->id); ?>">
    <i class="icon-favorite"></i> <span class="text"><?php echo e(resolve('favorites')->added($product->id) ? trans('favorites.remove_from_favorites') : trans('favorites.add_to_favorites')); ?></span>
</a>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/products/show/_buttons/_to_favorites.blade.php ENDPATH**/ ?>