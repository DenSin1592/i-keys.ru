<?php $__env->startSection('title'); ?>
    Константы
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo Form::tbModelWithErrors([], $errors, ['url' => route('cc.settings.update'), 'method' => 'put', 'scrollable' => false]); ?>

    <table class="table settings-table">
        <thead>
        <tr>
            <th class="col-name">Название</th>
            <th class="col-value">Значение</th>
        </tr>
        </thead>
        <?php $__currentLoopData = $formData['group_list']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tbody>
            <tr>
                <th colspan="2">
                    <span class="toggle" data-group-id="<?php echo e($group->getKey()); ?>"><?php echo e($group->getName()); ?></span>
                </th>
            </tr>
            </tbody>
            <tbody class="settings-group <?php echo Form::errorContains($group->getSettingKeys('setting.')) ? 'group-show' : ''; ?>"
                   data-group-id="<?php echo e($group->getKey()); ?>">
            <?php $__currentLoopData = $group->getSettingValueList(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="col-name">
                        <label for="setting-<?php echo e($setting->getPreparedKey()); ?>"><?php echo e($setting->getName()); ?>:</label>
                        <?php if(!empty($setting->getDescription())): ?>
                            <div class="setting-description"><?php echo $setting->getDescription(); ?></div>
                        <?php endif; ?>
                    </td>
                    <td class="col-value">
                        <?php echo Form::tbFormGroupOpen("setting.{$setting->getPreparedKey()}"); ?>

                            <?php if($setting->getType() === \App\Services\Settings\SettingValue::TYPE_TEXT): ?>
                                <?php echo Form::tbText("setting[{$setting->getPreparedKey()}]", $setting->getValue(), ['id' => "setting-{$setting->getPreparedKey()}", 'class' => 'form-control input-sm']); ?>


                            <?php elseif($setting->getType() === \App\Services\Settings\SettingValue::TYPE_TEXTAREA): ?>
                                <?php echo Form::tbTextarea("setting[{$setting->getPreparedKey()}]", $setting->getValue(), ['id' => "setting-{$setting->getPreparedKey()}", 'class' => 'form-control input-sm', 'rows' => 6]); ?>


                            <?php elseif($setting->getType() === \App\Services\Settings\SettingValue::TYPE_TEXTAREA_TINYMCE): ?>
                                <?php echo Form::tbTextarea("setting[{$setting->getPreparedKey()}]", $setting->getValue(), ['id' => "setting-{$setting->getPreparedKey()}", 'class' => 'form-control input-sm', 'rows' => 6, 'data-tinymce' => true]); ?>


                            <?php elseif($setting->getType() === \App\Services\Settings\SettingValue::TYPE_CHECKBOX): ?>
                                <input type="hidden" name="setting[<?php echo e($setting->getPreparedKey()); ?>]" value="0"/>
                                <?php echo Form::checkbox("setting[{$setting->getPreparedKey()}]", 1, $setting->getValue(), ['id' => "setting-{$setting->getPreparedKey()}", 'class' => 'checkbox']); ?>


                            <?php elseif($setting->getType() === \App\Services\Settings\SettingValue::TYPE_REDIRECTS): ?>
                                <?php echo $__env->make('admin.settings.form._redirects_field', ['rows' => old("setting.{$setting->getPreparedKey()}") ?: $setting->getValue()], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                            <?php else: ?>
                                <?php echo e($setting->getValue()); ?>

                            <?php endif; ?>
                        <?php echo Form::tbFormGroupClose(); ?>

                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <tfoot>
        <tr>
            <td class="col-name">&nbsp;</td>
            <td class="col-value">
                <button type="submit" class="btn btn-success">Сохранить</button>
            </td>
        </tr>
        </tfoot>
    </table>
    <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kristinayudina/works/l-keys.ru/www/resources/views/admin/settings/edit.blade.php ENDPATH**/ ?>