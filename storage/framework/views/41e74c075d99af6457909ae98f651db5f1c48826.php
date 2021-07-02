<div class="pagination-container">
    <?php echo $__env->make('client.shared.paginator._show_more', ['paginator' => $productsPaginator], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $productsPaginator->render('client.shared.paginator._pages'); ?>

</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/categories/_paginator.blade.php ENDPATH**/ ?>