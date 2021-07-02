<?php $__env->startSection('title'); ?>
    Администраторы
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="element-list-wrapper user-list">
        <div class="element-container header-container">
            <div class="name"><?php echo e(trans('validation.attributes.username')); ?></div>
            <div class="role"></div>
            <div class="ip"><?php echo e(trans('validation.attributes.allowed_ips')); ?></div>
            <div class="control"><?php echo e(trans('interactions.controls')); ?></div>
        </div>

        <ul class="element-list scrollable-container">
            <?php $__currentLoopData = $user_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <div class="element-container">
                        <div class="name">
                            <a href="<?php echo e(route('cc.admin-users.edit', [$user->id])); ?>">
                                <?php echo e($user->username); ?>

                            </a>
                        </div>
                        <div class="role">
                            <?php if($user->super): ?>
                                <span class="super-user">Суперпользователь</span>
                            <?php endif; ?>
                        </div>
                        <div class="ip">
                            <?php if(count($user->allowed_ips) == 0 || count($user->allowed_ips) == 1 && $user->allowed_ips[0] == ''): ?>
                                Все IP
                            <?php else: ?>
                                <?php echo implode('<br />', $user->allowed_ips); ?>

                            <?php endif; ?>
                        </div>
                        <div class="control">
                            <?php echo $__env->make('admin.admin_users._list_controls', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>

        <div>
            <a href="<?php echo e(route('cc.admin-users.create')); ?>" class="btn btn-success btn-xs">Добавить администратора</a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kristinayudina/works/l-keys.ru/www/resources/views/admin/admin_users/index.blade.php ENDPATH**/ ?>