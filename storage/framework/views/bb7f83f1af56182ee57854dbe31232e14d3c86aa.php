<div class="row">
    <div class="col-sm-4">
        <?php echo $__env->make('admin.settings.form._redirects_field._rule_field', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="col-sm-1" style="text-align: center;">
        <i class="fa fa-angle-right fa-2x" aria-hidden="true"></i>
    </div>
    <div class="col-sm-4">
        <?php echo $__env->make('admin.settings.form._redirects_field._url_field', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="col-sm-1">
        <button type="button" class="btn btn-default" data-rule-action="remove"><i class="fa fa-minus"></i></button>
    </div>
</div><?php /**PATH /home/kristinayudina/works/l-keys.ru/www/resources/views/admin/settings/form/_redirects_field/_row.blade.php ENDPATH**/ ?>