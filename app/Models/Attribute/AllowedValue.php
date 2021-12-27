<?php

namespace App\Models\Attribute;

use App\Models\Helpers\DeleteHelpers;
use App\Models\Product;


class AllowedValue extends \Eloquent
{
    protected $table = 'attribute_allowed_values';


    protected $fillable = [
        'value',
        'attribute_id',
        'position',
        'value_first_size_cylinder',
        'value_second_size_cylinder',
    ];


    public function attribute()
    {
        return $this->belongsTo('App\Models\Attribute');
    }


    public function singleValues()
    {
        return $this->hasMany('App\Models\Attribute\SingleValue', 'value_id');
    }


    public function multipleValues()
    {
        return $this->hasMany('App\Models\Attribute\MultipleValue', 'value_id');
    }


    public function getTypeSeries(): string
    {
        return AttributeConstants::SERIES_ATTRIBUTES_VARIANTS[$this->attribute_id];
    }


    public function productsForSingle()
    {
        return $this->belongsToMany(Product::class, 'attribute_single_values', 'value_id', 'product_id');
    }


    protected static function boot()
    {
        parent::boot();

        self::deleting(static function (self $allowedValue) {
            DeleteHelpers::deleteRelatedAll($allowedValue->singleValues());
            DeleteHelpers::deleteRelatedAll($allowedValue->multipleValues());
        });
    }
}
