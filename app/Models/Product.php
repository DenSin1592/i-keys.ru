<?php

namespace App\Models;

use App\Models\Product\HasAttributeValues;
use App\Models\Features\AutoPublish;
use App\Models\Helpers\DeleteHelpers;

class Product extends \Eloquent
{
    use AutoPublish;
    use HasAttributeValues;

    const VIEW_LIST = 'list';

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
        'extra_description',
        'code_1c'
    ];

    public function getNameWithCode1cAttribute()
    {
        $name = '';
        if (isset($this->code_1c) && $this->code_1c !== '') {
            $name .= "[{$this->code_1c}] ";
        }
        $name .= $this->name;

        return $name;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function relatedProducts()
    {
        return $this->belongsToMany(
            Product::class,
            'related_products',
            'product_id',
            'attached_product_id'
        );
    }


    public function relatedProductsReverse()
    {
        return $this->belongsToMany(
            Product::class,
            'related_products',
            'attached_product_id',
            'product_id'
        );
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
            $product->relatedProducts()->detach();
            $product->relatedProductsReverse()->detach();
        });
    }
}
