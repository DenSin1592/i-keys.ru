<!DOCTYPE html>
<html lang="en">
<head><?php echo $__env->make('admin.layouts._head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></head>

<body class="guest-container">

<div class="content-wrapper">
    <section class="well" <?php echo $__env->yieldContent('container_attributes'); ?>>
        <h1><?php echo $__env->yieldContent('title'); ?></h1>

        <?php echo $__env->make('admin.layouts._alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->yieldContent('content'); ?>
    </section>
</div>

<?php echo $__env->make('admin.layouts._footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>
</html><?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/layouts/guest.blade.php ENDPATH**/ ?>