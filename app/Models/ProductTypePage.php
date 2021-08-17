<?php namespace App\Models;

use App\Models\Features\AliasPath;
use App\Models\Features\AutoPublish;
use App\Models\Features\InTreePublish;
use App\Models\Features\TreeParentPath;
use App\Models\Helpers\DeleteHelpers;

class ProductTypePage extends \Eloquent
{
    use InTreePublish;
    use AutoPublish;
    use TreeParentPath;
    use AliasPath;

    const WAY_MANUAL = 'manual';
    const WAY_FILTERED = 'filtered';

    protected $fillable = [
        'parent_id',
        'alias',
        'name',
        'publish',
        'position',
        'header',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'content',
        'bottom_content',
        'category_id',
        'product_list_way',
        'filter_query',
    ];

    public function parent()
    {
        return $this->belongsTo(ProductTypePage::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ProductTypePage::class, 'parent_id');
    }


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * List of info about associated product type pages.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productTypePageAssociations()
    {
        return $this->hasMany(ProductTypePageAssociation::class, 'product_type_page_id');
    }

    /**
     * List of manually associated products.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function manualProducts()
    {
        return $this->belongsToMany(
            Product::class,
            'product_type_page_manual',
            'product_type_page_id',
            'product_id'
        );
    }

    /**
     * Value by default.
     *
     * @return string
     */
    public function getProductListWayAttribute()
    {
        return \Arr::get($this->attributes, 'product_list_way', self::WAY_FILTERED);
    }

    public static function availableWays()
    {
        return [
            self::WAY_FILTERED => 'по запросу фильтра',
            self::WAY_MANUAL => 'вручную',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(
            function (self $page) {
                DeleteHelpers::deleteRelatedAll($page->children());
                DeleteHelpers::deleteRelatedAll($page->productTypePageAssociations());

                $page->manualProducts()->detach();
            }
        );
    }
}
