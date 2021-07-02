<?php if($productsPaginator->currentPage() == 1 && $bottomContent != ''): ?>
        <div class="row">
            <div class="col">
                <?php echo $bottomContent; ?>

            </div>
        </div>
<?php endif; ?>

<?php echo $__env->make('client.categories.bottom_content._reviews', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('client.categories.bottom_content._videos', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('client.categories.bottom_content._links', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('client.categories.bottom_content._banners', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/categories/_bottom_content.blade.php ENDPATH**/ ?>