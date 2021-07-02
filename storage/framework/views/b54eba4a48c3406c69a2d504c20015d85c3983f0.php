<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        <?php echo Asset::includeCSS('client_css'); ?>

    </head>
    <body>
        <h1>Hello world!</h1>
    </body>
    <?php echo Asset::includeJS('client_js'); ?>

</html>
<?php /**PATH /home/kristinayudina/works/l-keys.ru/www/resources/views/welcome.blade.php ENDPATH**/ ?>