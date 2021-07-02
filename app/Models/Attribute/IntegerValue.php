<?php namespace App\Models\Attribute;

class IntegerValue extends AttributeValue
{
    protected $table = 'attribute_integer_values';
    protected $fillable = ['value'];
}
