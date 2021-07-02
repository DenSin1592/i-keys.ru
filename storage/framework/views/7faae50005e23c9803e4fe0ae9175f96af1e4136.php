<?php $__env->startSection('content'); ?>
    <div class="container">
        <?php echo $__env->make('client.shared.breadcrumbs._breadcrumbs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php if(false): ?>
            <?php echo $__env->make('client.shared.breadcrumbs._breadcrumbs_dropdown_example', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    </div>

    <?php echo $__env->make('client.categories._intro_block', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="container">
        <div class="row">
            <div class="catalog-aside filter-column filter-params col-xl-3" id="filter">
                <?php echo $__env->make('client.categories._filter_block', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <div class="filter-bgs-overlay d-xl-none"></div>

            <div class="col" id="category-content">
                <?php echo $__env->make('client.categories._category_content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('client.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/categories/show.blade.php ENDPATH**/ ?>