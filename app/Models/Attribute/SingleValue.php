<?php namespace App\Models\Attribute;

class SingleValue extends AttributeValue
{
    protected $table = 'attribute_single_values';

    public function allowedValue()
    {
        return $this->belongsTo('App\Models\Attribute\AllowedValue', 'value_id');
    }
}
