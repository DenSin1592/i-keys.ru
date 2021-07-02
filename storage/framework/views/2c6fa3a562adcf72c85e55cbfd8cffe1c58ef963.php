

<?php if(!empty($alert_success)): ?>
    <div class="alert alert-success">
        <?php echo e($alert_success); ?>

        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    </div>
<?php endif; ?>

<?php if(!empty($alert_error)): ?>
    <div class="alert alert-danger">
        <?php echo e($alert_error); ?>

        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    </div>
<?php endif; ?>
<?php /**PATH /home/kristinayudina/works/l-keys.ru/www/resources/views/admin/layouts/_alerts.blade.php ENDPATH**/ ?>