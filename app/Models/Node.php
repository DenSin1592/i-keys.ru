<?php namespace App\Models;

use App\Models\Features\AutoPublish;
use App\Models\Features\InTreePublish;
use App\Models\Features\TreeParentPath;
use App\Models\Helpers\DeleteHelpers;
use App\Models\TextPage;
use App\Models\HomePage;
use App\Models\MetaPage;

/**
 * App\Models\Node
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $alias
 * @property string $name
 * @property boolean $publish
 * @property integer $position
 * @property boolean $menu_top
 * @property string $type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property boolean $in_tree_publish
 * @property-read Node $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|Node[] $children
 * @property-read \App\Models\TextPage $textPage
 * @property-read \App\Models\HomePage $homePage
 * @property-read \App\Models\HomePage $metaPage
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Node whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Node whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Node whereAlias($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Node whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Node wherePublish($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Node wherePosition($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Node whereMenuTop($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Node whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Node whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Node whereUpdatedAt($value)
 */
class Node extends \Eloquent
{
    use InTreePublish;
    use AutoPublish;
    use TreeParentPath;

    const TYPE_HOME_PAGE = 'home_page';
    const TYPE_TEXT_PAGE = 'text_page';
    const TYPE_ERROR_PAGE = 'error_page';
    const TYPE_SERVICES_PAGE = 'services_page';

    protected $fillable = [
        'parent_id',
        'alias',
        'name',
        'publish',
        'position',
        'type',
        'menu_top',
    ];

    public function parent()
    {
        return $this->belongsTo(get_called_class(), 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(get_called_class(), 'parent_id');
    }

    public function textPage()
    {
        return $this->hasOne(TextPage::class);
    }

    public function servicePage()
    {
        return $this->hasOne(ServicePage::class);
    }

    public function homePage()
    {
        return $this->hasOne(HomePage::class);
    }

    public function metaPage()
    {
        return $this->hasOne(MetaPage::class);
    }

    /**
     * Get path of aliases for node.
     *
     * @return array
     */
    public function getAliasPath()
    {
        $nodeList = [];
        $element = $this;
        do {
            $nodeList[] = $element;
        } while (null !== $element = $element->parent);

        $aliasPath = array_map(
            function (self $node) {
                return $node->alias;
            },
            array_reverse($nodeList)
        );

        return $aliasPath;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(
            function (self $node) {
                // delete children
                DeleteHelpers::deleteRelatedAll($node->children());

                // delete attached info pages
                DeleteHelpers::deleteRelatedFirst($node->textPage());

                // delete attached home page
                DeleteHelpers::deleteRelatedFirst($node->homePage());

                // delete attached meta pages
                DeleteHelpers::deleteRelatedFirst($node->metaPage());
                DeleteHelpers::deleteRelatedFirst($node->servicePage());
            }
        );
    }
}
