<?php namespace App\Models;

use App\Models\Features\AutoPublish;
use App\Models\Features\InTreePublish;
use App\Models\Features\TreeAncestors;
use App\Models\Features\TreeParentPath;
use App\Models\Helpers\DeleteHelpers;

/**
 * Class Type
 * @package App\Models
 */
class Type extends \Eloquent
{
    use InTreePublish;
    use TreeParentPath;
    use TreeAncestors;
    use AutoPublish;

    protected $fillable = [
        'parent_id',
        'category_id',
        'name',
        'alias',
        'position',
        'publish',
        'header',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'content',
        'content_bottom',
    ];

    public function parent()
    {
        return $this->belongsTo(Type::class, 'parent_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function children()
    {
        return $this->hasMany(Type::class, 'parent_id');
    }

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (self $category) {
            DeleteHelpers::deleteRelatedAll($category->children());
        });
    }
}
