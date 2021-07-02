<?php
$options = [];
if (!empty($disabled)) {
    $options['disabled'] = true;
}
?>
<?php echo Form::tbText("attributes[{$attribute['attribute']->id}]", $attribute['data'], $options); ?>

<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/products/form/attributes/_attribute_integer.blade.php ENDPATH**/ ?>