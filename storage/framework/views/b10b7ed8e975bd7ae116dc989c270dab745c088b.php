<li class="breadcrumb-item <?php if($loop->last): ?> active <?php endif; ?>"  <?php if($loop->last): ?> aria-current="page" <?php endif; ?>>
    <?php if($loop->last): ?>
        <?php echo e($breadcrumb['name']); ?>

    <?php elseif(is_null($breadcrumb['url'])): ?>
        <?php echo e($breadcrumb['name']); ?>

    <?php else: ?>
        <a href="<?php echo e($breadcrumb['url']); ?>"><?php echo e($breadcrumb['name']); ?></a>
    <?php endif; ?>
</li>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/shared/breadcrumbs/_item.blade.php ENDPATH**/ ?>