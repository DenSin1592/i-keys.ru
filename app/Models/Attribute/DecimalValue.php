<?php namespace App\Models\Attribute;

class DecimalValue extends AttributeValue
{
    protected $table = 'attribute_decimal_values';
    protected $fillable = ['value'];
}
