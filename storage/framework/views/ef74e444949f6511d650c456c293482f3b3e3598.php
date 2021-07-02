<!--noindex-->
<div class="catalog-aside-content">
    <?php if(count($filterVariants->variants()) > 0): ?>
        <div class="row d-lg-none">
            <div class="col filter-title">Фильтр</div>
        </div>

        <button class="filter-close d-xl-none">
            <i class="icon-close"></i>
        </button>

        <?php echo $__env->make('client.shared.filter.form._form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <?php echo $__env->make('client.categories.filter_block._banners', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('client.categories.filter_block._links', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<!--/noindex-->
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/categories/_filter_block.blade.php ENDPATH**/ ?>