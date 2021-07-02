<div id="redirectsContainer">
    <div class="row" style="padding-top: 4px;">
        <div class="col-sm-4"><label>Правило</label></div>
        <div class="col-sm-1"></div>
        <div class="col-sm-4"><label>Ссылка</label></div>
        <div class="col-sm-1"></div>
    </div>

    <div>
        <div data-element-list="rules">
            <?php if(count($rows) > 0): ?>
                <?php $index = 0; ?>
                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('admin.settings.form._redirects_field._row', ['rule' => $row['rule'], 'url' => $row['url']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php $index++; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <?php echo $__env->make('admin.settings.form._redirects_field._row', ['index' => 0, 'rule' => null, 'url' => null], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </div>

        <?php echo $__env->make('admin.settings.form._redirects_field._template_row', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="row">
            <div class="col-sm-9"></div>
            <div class="col-sm-1">
                <button type="button" class="btn btn-default" data-rule-action="add"><i class="fa fa-plus"></i></button>
            </div>
        </div>
    </div>
</div><?php /**PATH /home/kristinayudina/works/l-keys.ru/www/resources/views/admin/settings/form/_redirects_field.blade.php ENDPATH**/ ?>