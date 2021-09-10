<?php

namespace App\Models;

class DeliveryAddress extends \Eloquent
{
    protected $fillable = [
        'postcode',
        'region_id',
        'city',
        'street',
        'building',
        'flat',
        'comment',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
}
