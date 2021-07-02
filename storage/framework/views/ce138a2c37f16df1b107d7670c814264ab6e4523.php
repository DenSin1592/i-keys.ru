<a href="<?php echo e($url); ?>" target="_blank" class="navbar-brand">
    <?php if($siteName = \Setting::get('admin.site_name')): ?>
        <?php echo $siteName; ?> (<?php echo e(\Str::lower(trans('interactions.go_to_site'))); ?>)
    <?php else: ?>
        <?php echo trans('interactions.go_to_site'); ?>

    <?php endif; ?>
</a>
<?php /**PATH /home/kristinayudina/works/l-keys.ru_2021/www/resources/views/admin/shared/_go_to_site_button.blade.php ENDPATH**/ ?>