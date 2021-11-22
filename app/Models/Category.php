<?php

namespace App\Models;

use App\Models\Features\AliasPath;
use App\Models\Features\AutoPublish;
use App\Models\Helpers\DeleteHelpers;
use App\Models\Features\InTreePublish;
use App\Models\Features\TreeAncestors;
use App\Models\Features\TreeParentPath;
use Diol\FileclipExif\Glue;

class Category extends \Eloquent
{
    public const CATALOG_TYPE_IMAGE_ARE_IMPORTANT = 'image_are_important';
    public const CATALOG_TYPE_CHARACTERISTICS_ARE_IMPORTANT = 'characteristics_are_important';

    public const CILINDR_MEHANIZMY_1C_CODE = 21741;

    use Glue;
    use InTreePublish;
    use TreeParentPath;
    use TreeAncestors;
    use AutoPublish;
    use AliasPath;

    protected $fillable = [
        'parent_id',
        'name',
        'alias',
        'publish',
        'position',
        'top_content',
        'content',
        'bottom_content',
        'header',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'catalog_type',
        'code_1c',
        'path_to_icon'
    ];

    public static function getCatalogTypes()
    {
        return [
            self::CATALOG_TYPE_IMAGE_ARE_IMPORTANT,
            self::CATALOG_TYPE_CHARACTERISTICS_ARE_IMPORTANT,
        ];
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }


    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }


    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }


    protected static function boot()
    {
        parent::boot();

        self::deleting(function (self $category) {
            DeleteHelpers::deleteRelatedAll($category->products());
            DeleteHelpers::deleteRelatedAll($category->children());
            DeleteHelpers::deleteRelatedAll($category->attributes());

            ProductTypePage::where('category_id', $category->id)->update(['category_id' => null]);
        });
    }
}
