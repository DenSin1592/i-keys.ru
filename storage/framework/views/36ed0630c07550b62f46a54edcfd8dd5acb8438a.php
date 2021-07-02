<?php if($paginator->hasPages()): ?>

    <nav class="pagination d-flex mt-3" aria-label="pagination">
        
        <?php if($paginator->onFirstPage()): ?>
            <div class="page-item prev d-none d-md-block page-item-disabled"><span class="page-link"><span>Предыдущая</span></span></div>
        <?php else: ?>
            <div class="page-item prev d-none d-md-block">
                <a class="page-link" href="<?php echo e($paginator->previousPageUrl()); ?>"><span>Предыдущая</span></a>
            </div>
        <?php endif; ?>


        
        <ul class="pagination-list d-flex align-items-center">
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <?php if(is_string($element)): ?>
                    <li class="page-item page-item-sep"><span class="page-link"><?php echo e($element); ?></span></li>
                <?php endif; ?>

                
                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <li class="page-item active" aria-current="page"><a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a></li>
                        <?php else: ?>
                            <li class="page-item"><a class="page-link" href="<?php echo e($url); ?>"><?php echo e($page); ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>


        
        <?php if($paginator->hasMorePages()): ?>
            <div class="page-item next d-none d-md-block"><a class="page-link" href="<?php echo e($paginator->nextPageUrl()); ?>"><span>Следующая</span></a></div>
        <?php else: ?>
            <div class="page-item next d-none d-md-block page-item-disabled"><span class="page-link"><span>Следующая</span></span></div>
        <?php endif; ?>
    </nav>
<?php endif; ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/shared/paginator/_pages.blade.php ENDPATH**/ ?>