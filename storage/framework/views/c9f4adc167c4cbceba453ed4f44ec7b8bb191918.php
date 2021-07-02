<?php if(count($topMenu) > 0): ?>
    <div class="col d-none d-xl-block">
        <nav class="header-nav-box text-center">
            <ul class="nav header-nav reset-list">
                <?php $__currentLoopData = $topMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuElement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="nav-item <?php echo e($menuElement['active'] ? 'active' : ''); ?>">
                        <a href="<?php echo e($menuElement['url']); ?>" class="nav-link"><?php echo e($menuElement['name']); ?></a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </nav>
    </div>
<?php endif; ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/layouts/header/header_top/_top_menu.blade.php ENDPATH**/ ?>