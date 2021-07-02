<?php namespace App\Models\Attribute;

use App\Models\Product;

/**
 * Class AttributeValue
 * Abstract attribute value.
 * @package App\Models\Attribute
 */
abstract class AttributeValue extends \Eloquent
{
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function attribute()
    {
        return $this->belongsTo('App\Models\Attribute');
    }
}
