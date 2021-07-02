<?php namespace App\Models\Features;

use Illuminate\Database\Eloquent\Collection;

/**
 * Trait TreeAncestors
 * Trait adds functionality to the model to work with ancestors and descendants.
 *
 * Migration should be created. Example:
 *      public function up()
 *      {
 *          Schema::create('<model_table>_ancestors', function (Blueprint $table) {
 *              $table->increments('id');
 *              $table->unsignedInteger('descendant_id');
 *              $table->unsignedInteger('ancestor_id');
 *              $table->foreign('descendant_id', '<model_table>_ancestor_descendant_fk')
 *                  ->references('id')->on('<model_table>');
 *              $table->foreign('ancestor_id', '<model_table>_ancestor_ancestor_fk')
 *                  ->references('id')->on('<model_table>');
 *              $table->unique(['descendant_id', 'ancestor_id'], '<model_table>_ancestor_unique');
 *          });
 *      }
 *
 *      public function down()
 *      {
 *          Schema::drop('<model_table>_ancestors');
 *      }
 *
 * Where "<model_table>" - model table.
 *
 * Created table will store all the ancestors and descendants for each model element.
 *
 * Rows in created table will be automatically rebuild on model save/delete.
 * To rebuild all the data in table call static method self::rebuildElementAncestors.
 *
 * @package App\Models\Features
 */
trait TreeAncestors
{
    public function ancestors()
    {
        return $this->belongsToMany(
            get_called_class(),
            $this->getTable() . '_ancestors',
            'descendant_id',
            'ancestor_id'
        );
    }


    public function descendants()
    {
        return $this->belongsToMany(
            get_called_class(),
            $this->getTable() . '_ancestors',
            'ancestor_id',
            'descendant_id'
        );
    }


    /**
     * Load ancestors for each element in the collection.
     * All the parents in collection will be filled.
     *
     * @param $collection
     */
    public static function loadAncestors($collection)
    {
        $table = (new self())->getTable();

        $itemIds = [];
        foreach ($collection as $item) {
            $itemIds[] = $item->id;
        }
        if (count($itemIds) > 0) {
            $ancestors = self::query()
                ->join("{$table}_ancestors", "{$table}_ancestors.ancestor_id", '=', "{$table}.id")
                ->whereIn("{$table}_ancestors.descendant_id", $itemIds)
                ->select("{$table}.*")->distinct()->get();
        } else {
            $ancestors = Collection::make([]);
        }

        $categoriesDict = $ancestors->getDictionary();
        foreach ($collection as $item) {
            $categoriesDict[$item->id] = $item;
        }

        foreach ($categoriesDict as $category) {
            $parentId = $category->parent_id;
            if (!is_null($parentId) && isset($categoriesDict[$parentId])) {
                $category->parent()->associate($categoriesDict[$parentId]);
            }
        }
    }


    /**
     * Rebuild ancestors for element.
     *
     * @param $element
     * @param null $parentIds
     */
    private static function rebuildElementAncestors(self $element, $parentIds = null)
    {
        \DB::beginTransaction();

        $ancestors = [];
        if (!is_array($parentIds)) {
            $parentIds = [];
            $cursor = $element;
            while (!is_null($cursor->parent_id)) {
                $parentIds[] = $cursor->parent_id;
                $cursor = $cursor->parent()->first();
            }
        }
        $ancestors = array_merge($ancestors, $parentIds);

        $element->ancestors()->sync($ancestors);
        $ancestors[] = $element->id;
        foreach ($element->children()->get() as $childElement) {
            self::rebuildElementAncestors($childElement, $ancestors);
        };

        \DB::commit();
    }


    /**
     * Rebuild all the ancestors.
     */
    public static function rebuildAncestors()
    {
        foreach (self::whereNull('parent_id')->get() as $element) {
            self::rebuildElementAncestors($element);
        }
    }


    protected static function bootTreeAncestors()
    {
        self::deleting(function (self $element) {
            $element->ancestors()->detach();
            $element->descendants()->detach();
        });

        self::saved(function (self $element) {
            self::rebuildElementAncestors($element);
        });
    }
}
