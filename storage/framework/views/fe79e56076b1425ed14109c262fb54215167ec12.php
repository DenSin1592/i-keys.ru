<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $__env->make('admin.layouts._head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<body>
    <?php echo $__env->make('admin.layouts._top_nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="structure-columns-container">
        <?php echo $__env->make('admin.layouts._main_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->yieldContent('second_column'); ?>

        <div class="content-wrapper main-content">
            <h1><?php echo $__env->yieldContent('title'); ?></h1>
            <?php echo $__env->make('admin.layouts._alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <?php echo $__env->make('admin.layouts._footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html><?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/layouts/default.blade.php ENDPATH**/ ?>