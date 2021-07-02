<a class="glyphicon glyphicon-pencil"
   title="<?php echo e(trans('interactions.edit')); ?>"
   href="<?php echo e(route('cc.admin-users.edit', [$user->id])); ?>"></a>

<?php if(Auth::user()->id == $user->id): ?>
    <span class="glyphicon glyphicon-trash" title="<?php echo e(trans('alerts.delete_is_disallowed')); ?>"></span>
<?php else: ?>
    <a class="glyphicon glyphicon-trash"
       title="<?php echo e(trans('interactions.delete')); ?>"
       data-method="delete"
       data-confirm="Вы уверены, что хотите удалить данного администратора?"
       href="<?php echo e(route('cc.admin-users.destroy', [$user->id])); ?>"></a>
<?php endif; ?>
<?php /**PATH /home/kristinayudina/works/l-keys.ru/www/resources/views/admin/admin_users/_list_controls.blade.php ENDPATH**/ ?>