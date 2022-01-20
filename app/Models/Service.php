<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends \Eloquent
{
    use HasFactory;

    protected $fillable = [
        'name',
        'alias',
        'image',
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

    private string $noImageVersion = 'no-image-200x200.png';

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function getImageOrStub(): string
    {
        if (! is_null($this->image)){
            return asset('/uploads/services/' . $this->image);
        }
        return asset('/images/common/no-image/' . $this->noImageVersion);
    }
}
