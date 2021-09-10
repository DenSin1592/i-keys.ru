<?php

namespace App\Models;

class Region extends \Eloquent
{
    protected $fillable = ['name', 'position'];

    public function orders()
    {
        return $this->hasMany(Order::class, 'region_id');
    }

    public function deliveryAddresses()
    {
        return $this->hasMany(DeliveryAddress::class, 'region_id');
    }

    public function getDisallowDeleteAttribute()
    {
        return $this->orders->count() > 0 || $this->deliveryAddresses->count() > 0;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(
            function (self $region) {
                Order::where('region_id', $region->id)->update(['region_id' => null]);
                DeliveryAddress::where('region_id', $region->id)->update(['region_id' => null]);
            }
        );
    }
}