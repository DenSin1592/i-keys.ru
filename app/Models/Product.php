<?php namespace App\Models;

use App\Models\Product\HasAttributeValues;
use App\Models\Features\AutoPublish;
use App\Models\Helpers\DeleteHelpers;
use App\Models\Category;
use App\Models\ProductImage;

class Product extends \Eloquent
{
    use AutoPublish;
    use HasAttributeValues;

    protected $fillable = [
        'category_id',
        'name',
        'alias',
        'position',
        'publish',
        'price',
        'description',
        'header',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'extra_description  ',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }


    protected static function boot()
    {
        parent::boot();

        self::deleting(function (self $product) {
            DeleteHelpers::deleteRelatedAll($product->images());
        });
    }
}
