<?php if(isset($relinkData) && count($relinkData) > 0): ?>
    <div class="row">
        <div class="col">
            <h2 class="mt-4">Похожие товары</h2>
            <?php $__currentLoopData = $relinkData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relinkGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <p>
                    <strong><?php echo e($relinkGroup['name']); ?>:</strong>
                    <?php $__currentLoopData = $relinkGroup['links']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a class="d-inline-block ml-2" data-filter-link="1" href="<?php echo e($link['url']); ?>"><?php echo e($link['name']); ?></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/categories/_relink.blade.php ENDPATH**/ ?>