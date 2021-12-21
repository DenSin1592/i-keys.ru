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

    public const LOCKS_ID = 1;
    public const DOOR_HANDLES_ID = 2;
    public const FINDINGS_ID = 3;

    public const CILINDRY_1C_CODE = '000001';
    public const CILINDR_MEHANIZMY_CISA_1C_CODE = '21741';
    public const ARMORPLATE_CISA_1C_CODE = '21739';

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
        'code_1c',
        'path_to_icon',
        'menu_top',
        'content_for_submenu',
        'content_for_links_type',
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
        return $this->belongsToMany(Attribute::class);
    }

    protected static function boot()
    {
        parent::boot();

        self::bootTreeAncestors();

        self::deleting(function (self $category) {
            DeleteHelpers::deleteRelatedAll($category->products());
            DeleteHelpers::deleteRelatedAll($category->children());
            $category->attributes()->detach();
            ProductTypePage::where('category_id', $category->id)->update(['category_id' => null, 'publish' => 0]);
        });
    }
}
