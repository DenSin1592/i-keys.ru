<a class="product-compare-toggle <?php if(resolve('comparer')->added($product->id)): ?> added <?php endif; ?> product-action d-inline-flex align-items-center justify-content-center nowrap" href="javascript:void(0);"
   data-product-id="<?php echo e($product->id); ?>">
    <i class="icon-compare"></i> <span class="text"><?php echo e(resolve('comparer')->added($product->id) ? trans('compare.remove_from_compare') : trans('compare.add_to_compare')); ?></span>
</a>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/products/show/_buttons/_to_compare.blade.php ENDPATH**/ ?>