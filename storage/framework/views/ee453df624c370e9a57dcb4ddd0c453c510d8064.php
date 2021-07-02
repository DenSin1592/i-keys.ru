<a data-product-id="<?php echo e($product->id); ?>"
   href="javascript:void(0);"
   class="product-compare-toggle product-action  <?php if(resolve('comparer')->added($product->id)): ?> added <?php endif; ?>"
   title="<?php echo e(resolve('comparer')->added($product->id) ? 'Уже в сравнении' : 'Сравнить'); ?>">
    <i class="icon-compare" ></i>
</a>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/shared/products/_compare_button.blade.php ENDPATH**/ ?>