<?php namespace App\Models\Attribute;

use App\Models\Helpers\DeleteHelpers;

class AllowedValue extends \Eloquent
{
    protected $table = 'attribute_allowed_values';
    protected $fillable = ['value', 'position'];

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

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (self $allowedValue) {
            DeleteHelpers::deleteRelatedAll($allowedValue->singleValues());
            DeleteHelpers::deleteRelatedAll($allowedValue->multipleValues());
        });
    }
}
