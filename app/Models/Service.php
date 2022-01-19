<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends \Eloquent
{
    use HasFactory;

    protected $fillable = [
        'name',
        'alias',
        'content',
        'position',
        'publish',
        'price',
        'description',
        'header',
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
