<?php if(isset($currentAdminUser)): ?>
    <div id="auth-menu" class="closed">
        <div class="content-wrapper">
            <?php if(isset($authEditLink)): ?>
                <div class="action-container">
                    <a target="_blank" href="<?php echo e($authEditLink); ?>" id="auth-menu-link"><span class="glyphicon glyphicon-pencil"></span>Редактировать</a>
                </div>
                <div class="divider-vertical"></div>
            <?php endif; ?>
            <div class="login">
                Ваш логин: <a href="<?php echo e(route('cc.home')); ?>"><?php echo e(object_get($currentAdminUser, 'username')); ?></a>
            </div>
            <div class="divider-vertical"></div>
        </div>

        <span class="toggle-button" data-action="toggle">
            <img class="logotype" src="<?php echo e(Asset::timed('/images/admin/diol.png')); ?>">
        </span>
    </div>
<?php endif; ?>


<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/layouts/_auth_menu.blade.php ENDPATH**/ ?>