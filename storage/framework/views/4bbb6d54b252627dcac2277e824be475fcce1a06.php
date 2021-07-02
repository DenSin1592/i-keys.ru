<?php echo $__env->make('client.categories._header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="row">
    <?php echo $__env->make('client.shared.filter._current_values', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php if(count($filterVariants->variants()) > 0): ?>
        <div class="col-auto d-none d-md-inline-flex d-xl-none justify-content-end">
            <a class="section-link filter-show filter-show-in-row filter-toggler d-flex flex-nowrap" href="javascript:void(0);"><i class="icon-filter"></i> <span>Показать фильтры</span></a>
        </div>
    <?php endif; ?>
</div>

<div class="row">
    <?php if(count($productListData) > 0): ?>
        <?php echo $__env->make('client.categories._sorting', ['sortingVariants' => $sortingVariants], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <?php if(count($filterVariants->variants()) > 0): ?>
        <div class="col-auto d-inline-flex d-md-none justify-content-end">
            <a class="section-link filter-show filter-toggler d-flex flex-nowrap d-lg-none" href="javascript:void(0);"><i class="icon-filter"></i> <span class="d-sm-none">Фильтры</span> <span class="d-none d-sm-inline-block">Показать фильтры</span></a>
        </div>
    <?php endif; ?>
</div>

<?php echo $__env->make('client.categories._popular', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('client.categories._top_content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('client.categories._products', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('client.categories._paginator', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('client.categories._relink', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('client.categories._bottom_content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/categories/_category_content.blade.php ENDPATH**/ ?>