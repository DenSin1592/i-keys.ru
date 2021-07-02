

<aside class="menu-column <?php echo $__env->yieldContent('main_menu_class'); ?>">
    <div class="menu-wrapper main-menu">
        <div class="menu-toggle">
            <span class="menu-toggle-header content-wrapper">Панель управления</span>
            <span class="btn-container">
                <span class="btn btn-default glyphicon glyphicon-step-backward close-menu"></span>
                <span class="btn btn-default glyphicon glyphicon-step-forward open-menu"></span>
            </span>
        </div>

        <?php echo $__env->make('admin.layouts._main_menu_lvl', ['menu_lvl' => $main_menu], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</aside>
<?php /**PATH /home/kristinayudina/works/l-keys.ru/www/resources/views/admin/layouts/_main_menu.blade.php ENDPATH**/ ?>