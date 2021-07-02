<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $__env->yieldContent('title', $meta_title ?? ''); ?></title>
    <?php if(isset($meta_description)): ?>
        <meta name="description" content="<?php echo e($meta_description); ?>"/>
    <?php endif; ?>
    <?php if(isset($meta_keywords)): ?>
        <meta name="keywords" content="<?php echo e($meta_keywords); ?>"/>
    <?php endif; ?>
    <?php if(isset($canonicalUrl)): ?>
        <link rel="canonical" href="<?php echo e($canonicalUrl); ?>"/>
    <?php endif; ?>

    <?php echo $__env->make('client.layouts._favicon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo Asset::includeCSS('client_css'); ?>


    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <?php if(App::environment() == 'production'): ?>
        <script type="application/json" id="recaptcha-site-key"><?php echo json_encode(env('RECAPTCHA_SITE_KEY')); ?></script>
    <?php endif; ?>

    <script type="text/javascript" src="/vendor/cdek_widget/widjet.js" id="ISDEKscript" ></script>

</head>

<body>

<script type="text/javascript"src="https://points.boxberry.de/js/boxberry.js"></script>

<?php echo $__env->make('client.layouts._auth_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="wrapper">
    <div class="content-box">
        <?php echo $__env->make('client.layouts._header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- todo: remove padding bottom -->
        <main class="main" style="padding-bottom: 20px;">
            <?php echo $__env->yieldContent('content'); ?>
            <?php echo $__env->make('client.layouts._registration', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('client.layouts._recently_viewed', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </main>
    </div>

    <?php echo $__env->make('client.layouts._footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</div>

<?php echo $__env->make('client.layouts._offcanvas', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('client.layouts.modals._login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('client.layouts.modals._callback', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('client.layouts.modals._message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('client.layouts.modals._cart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('client.layouts.modals._city', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('client.layouts.modals._card', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('client.layouts.modals._compare', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('client.layouts.modals._favorites', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('client.layouts.modals._review', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<button class="back-to-top">
    <i class="icon-arrow-up"></i>
</button>

<?php echo Asset::includeJS('client_js'); ?>

<?php if(App::environment() == 'production'): ?>
    <?php echo $__env->make('client.layouts.counters._google', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('client.layouts.counters._yandex', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
</body>
</html>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/layouts/default.blade.php ENDPATH**/ ?>