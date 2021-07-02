<?php namespace App\Models\Attribute;

class MultipleValue extends AttributeValue
{
    protected $table = 'attribute_multiple_values';

    public function allowedValue()
    {
        return $this->belongsTo('App\Models\Attribute\AllowedValue', 'value_id');
    }
}
