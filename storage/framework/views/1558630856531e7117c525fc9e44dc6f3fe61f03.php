<?php $__env->startSection('title'); ?>
    Авторизация

    <?php if($siteName = \Setting::get('admin.site_name')): ?>
        (<?php echo \Str::lower($siteName); ?>)
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo Form::open(array('url' => route('cc.login'))); ?>


        <div class="form-group <?php echo e($incorrect ? 'has-error' : ''); ?>">
            <?php echo Form::label('username', 'Имя пользователя', ['class' => 'control-label']); ?>

            <?php echo Form::text('username', $credentials['username'], ['class' => 'form-control', 'placeholder' => 'Введите логин', 'autofocus' => 'autofocus']); ?>

        </div>

        <div class="form-group <?php echo e($incorrect ? 'has-error' : ''); ?>">
            <?php echo Form::label('password', 'Пароль', ['class' => 'control-label']); ?>

            <?php echo Form::password('password', ['class' => 'form-control', 'placeholder' => 'Введите пароль']); ?>

        </div>

        <div class="remember-me">
            <label><?php echo Form::checkbox('remember', 1, $remember); ?> Запомнить меня</label>
        </div>

        <div class="submit-container">
            <button type="submit" class="btn btn-primary">Вход</button>
        </div>

    <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.guest', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/session/login.blade.php ENDPATH**/ ?>