<?php
$options = [];
if (!empty($disabled)) {
    $options['disabled'] = true;
}
?>
{!! Form::tbText("attributes[{$attribute['attribute']->id}]", $attribute['data'],  $options) !!}
