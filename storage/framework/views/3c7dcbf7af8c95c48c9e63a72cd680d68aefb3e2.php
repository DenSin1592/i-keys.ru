<?php
$options = [];
if (!empty($disabled)) {
    $options['disabled'] = true;
}
?>
<?php echo Form::tbSelect2("attributes[{$attribute['attribute']->id}]", $attribute['allowedValues'], $attribute['data'], $options); ?>

<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/products/form/attributes/_attribute_single.blade.php ENDPATH**/ ?>