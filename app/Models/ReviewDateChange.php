<?php namespace App\Models;

class ReviewDateChange extends \Eloquent
{
    protected $fillable = [
        'iteration',
        'old_value',
        'new_value'
    ];

    protected $dates = [
        'old_value',
        'new_value'
    ];

    public function review()
    {
        return $this->belongsTo('App\Models\Review');
    }
}
