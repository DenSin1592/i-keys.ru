<?php
use App\Services\Breadcrumbs\Factory;

$breadcrumbs = resolve(Factory::class)->init();
$breadcrumbs->add('Страница не найдена');
?>

<?php $__env->startSection('title', 'Страница не найдена'); ?>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <?php echo $__env->make('client.shared.breadcrumbs._breadcrumbs', ['breadcrumbs' => $breadcrumbs], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="display-header">
            <div class="display-title">Страница не найдена</div>
        </div>

        <div class="content">
            Запрашиваемая вами страница не существует или была удалена.<br/>
            Вы можете вернуться на <?php echo e(link_to_route('home', 'главную страницу')); ?>.
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('client.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/errors/404/client.blade.php ENDPATH**/ ?>