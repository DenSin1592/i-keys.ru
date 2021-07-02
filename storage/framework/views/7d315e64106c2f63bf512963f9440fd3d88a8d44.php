<?php $__env->startSection('content'); ?>
    <div class="container">
        <?php echo $__env->make('client.shared.breadcrumbs._breadcrumbs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <div class="container">
        <div class="row">

            <div class="col">
                <div class="row">
                    <div class="col d-flex align-items-center">
                        <h1 class="mb-0"><?php echo e($h1); ?></h1>
                        <span class="badge badge-txt badge-title nowrap"><?php echo e(trans_choice('messages.product', $productsPaginator->total())); ?></span>
                    </div>
                </div>

                <?php if($productsPaginator->total() > 0): ?>
                    <section class="section-catalog p-0 m-0">
                        <div class="catalog-grid row">
                            <?php echo $__env->make('client.search.index._products', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </section>

                    <?php echo $__env->make('client.shared.paginator._show_more', ['paginator' => $productsPaginator], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $productsPaginator->render('client.shared.paginator._pages'); ?>

                <?php else: ?>
                    <p>По запросу "<?php echo e($query); ?>" не найдено ни одного товара.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('client.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/search/index.blade.php ENDPATH**/ ?>