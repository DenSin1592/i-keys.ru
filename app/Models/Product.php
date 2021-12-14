<?php

namespace App\Models;

use App\Models\Helpers\AliasHelpers;
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
        'code_1c',
        'old_price',
        'best_prod',
        'existence',
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


    public function typePages()
    {
        return $this->belongsToMany(
            ProductTypePage::class,
            'product_type_page_manual',
            'product_id',
            'product_type_page_id',
        );
    }


    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }


    public function getFirstImagePath(string $field, ?string $version, string $noImageVersion): string
    {
        $image = $this->images->first();
        if($image instanceof ProductImage){
            return $image->getImgPath($field, $version, $noImageVersion);
        }

        return asset('/images/common/no-image/' . $noImageVersion);
    }


    public function getOldPrice(): ?string
    {
        return $this->old_price > $this->price ? $this->old_price : null;
    }


    public function getSaleStringAttribute(): ?string
    {
        if(is_null($this->getOldPrice())) return null;

        $sale = (int) (100 - ($this->price / $this->getOldPrice() * 100));
        return "Экономия ${sale}%";
    }


    public function orderItem()
    {
        return $this->hasOne(OrderItem::class,);
    }


    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    public function isCylinder(): bool
    {
        $categoryPath = $this->category->extractPath();
        if($categoryPath[1]->code_1c === Category::CILINDRY_1C_CODE){
            return true;
        }
        return false;
    }


    public function getExistenceString(): string
    {
        return trans("validation.model_attributes.product.existence.{$this->existence}");
    }


    protected static function boot()
    {
        parent::boot();

        self::deleting(function (self $product) {
            DeleteHelpers::deleteRelatedAll($product->images());
            DeleteHelpers::deleteRelatedAll($product->orderItem());
            DeleteHelpers::deleteRelatedAll($product->reviews());
            $product->relatedProducts()->detach();
            $product->relatedProductsReverse()->detach();
            $product->typePages()->detach();
        });


        self::saving(function (self $product) {
            AliasHelpers::setAlias($product);
        });
    }
}
