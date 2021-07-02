<?php
$options = [];
if (!empty($disabled)) {
    $options['disabled'] = true;
}
?>
{!! Form::tbSelect2("attributes[{$attribute['attribute']->id}]", $attribute['allowedValues'], $attribute['data'], $options) !!}
