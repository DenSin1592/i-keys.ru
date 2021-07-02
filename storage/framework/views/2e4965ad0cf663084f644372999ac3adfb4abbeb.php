<div class="product-labels-box flex-row flex-wrap">
    <?php if(false): ?>
        <div class="product-label label label-danger nowrap">Новинка</div>
        <div class="product-label label label-purple nowrap">Хит продаж</div>
        <div class="product-label label label-success nowrap">Распродажа</div>
    <?php endif; ?>

    <?php if($productData['product']->discount_percent): ?>
        <div class="product-label label label-warning nowrap">- <?php echo e($productData['product']->discount_percent); ?>%</div>
    <?php endif; ?>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/products/show/_images/_actions.blade.php ENDPATH**/ ?>