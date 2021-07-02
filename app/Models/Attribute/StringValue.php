<?php namespace App\Models\Attribute;

class StringValue extends AttributeValue
{
    protected $table = 'attribute_string_values';
    protected $fillable = ['value'];
}
