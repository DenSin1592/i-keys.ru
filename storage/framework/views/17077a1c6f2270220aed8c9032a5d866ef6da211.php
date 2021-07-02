<div class="d-flex row m-0 p-0 w-100">

    <div class="footer-subnav-box col-8 p-0">
        <ul class="footer-subnav">
            <?php $__currentLoopData = $bottomMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuElement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="nav-item <?php echo e($menuElement['active'] ? 'active' : ''); ?>">
                    <a href="<?php echo e($menuElement['url']); ?>" class="nav-link"><?php echo e($menuElement['name']); ?></a>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>

    <!--noindex-->
    <div class="footer-subnav-box col-4">
        <a href="tel:<?php echo e($sitePhone['short']); ?>" class="footer-contact">
            <i class="icon-phone"></i>
            <?php echo e($sitePhone['full']); ?>

        </a>
        <div class="footer-clock">
            <i class="icon-clock-o d-md-inline-block" ></i>
            Круглосуточно
        </div>
    </div>
    <!--/noindex-->
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/layouts/footer/_bottom_menu.blade.php ENDPATH**/ ?>