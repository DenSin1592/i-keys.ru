

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#top-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a id="logotype" href="<?php echo e(route('cc.home')); ?>">
                <img src="<?php echo e(Asset::timed('images/admin/diol.png')); ?>" alt="Проект">
            </a>
        </div>

        <div class="collapse navbar-collapse" id="top-navbar-collapse">
            <?php if(isset($currentAdminUser)): ?>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <span class="navbar-text">Ваш логин: <strong><?php echo e($currentAdminUser['username']); ?></strong></span>
                </li>
                <li>
                    <a href="<?php echo e(route('cc.logout')); ?>" data-method="delete" id="cc-logout">
                        <span class="glyphicon glyphicon-off"></span> Выход
                    </a>
                </li>
            </ul>
            <?php endif; ?>
            <div class="project">
                <?php $__env->startSection('go_to_site_link'); ?>
                    <?php if(Route::has('home')): ?>
                        <?php echo $__env->make('admin.shared._go_to_site_button', ['url' => route('home')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                <?php echo $__env->yieldSection(); ?>
            </div>
        </div>
    </div>
</nav>
<?php /**PATH /home/kristinayudina/works/l-keys.ru_2021/www/resources/views/admin/layouts/_top_nav.blade.php ENDPATH**/ ?>