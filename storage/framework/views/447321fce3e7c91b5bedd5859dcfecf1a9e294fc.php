<input type="text"
       class="form-control"
       name="setting[<?php echo $setting->getKey(); ?>][<?php echo $index; ?>][<?php echo $field; ?>]"
       value="<?php echo $value; ?>"
       <?php if(!empty($disabled)): ?> disabled="disabled" <?php endif; ?>
/>

<?php if(isset($setting, $index)): ?>
    <?php echo Form::tbFormFieldError("setting.{$setting->getKey()}.{$index}.{$field}"); ?>

<?php endif; ?>
<?php /**PATH /home/kristinayudina/works/l-keys.ru/www/resources/views/admin/settings/form/_redirects_field/_text_field.blade.php ENDPATH**/ ?>