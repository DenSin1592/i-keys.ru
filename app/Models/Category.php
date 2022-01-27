<?php

namespace App\Models;

use App\Jobs\ToggleSearchableForProductsInCategory;
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
    public const COPIES_KEYS_ID = 4;
    public const IMPORT_ID = 7;

    public const LOCKS_ALIAS = 'zamki';
    public const CYLINDERS_ALIAS = 'tsilindry';
    public const FURNITURA_ALIAS = 'furnitura';
    public const RUCHKI_ALIAS = 'ruchki';
    public const KOPII_CLUCHEY_ALIAS = 'kopii-klyuchey';

    public const MAPPING_ALIASES = [
        self::LOCKS_ALIAS => 'Замки',
        self::CYLINDERS_ALIAS => 'Цилиндры',
        self::FURNITURA_ALIAS => 'Фурнитура',
        self::RUCHKI_ALIAS => 'Ручки',
        self::KOPII_CLUCHEY_ALIAS => 'Копии ключей',
    ];

    public const LOCKS_1C_CODE = '000001';
    public const CILINDRY_1C_CODE = '000002';
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

    protected $casts = [
        'in_tree_publish' => 'boolean',
        'publish' => 'boolean',
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

        self::saving(function (self $category) {
            if (collect($category->getDirty())->has('publish')) {
                ToggleSearchableForProductsInCategory::dispatch($category)->onQueue('search');
            }
        });

    }
}
