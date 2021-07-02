<?php namespace App\Models\Features;

use Illuminate\Database\Eloquent\Collection;

/**
 * Trait TreeParentPath
 *
 * @package App\Models\Features
 */
trait TreeParentPath
{
    /**
     * Cache of parent path.
     *
     * @var array|null
     */
    protected $parentPath;


    /**
     * Extract parent path.
     *
     * @return array
     */
    public function extractParentPath()
    {
        if (is_null($this->parentPath)) {
            $element = $this;
            $path = [];
            while (!is_null($element->parent_id)) {
                $path[] = $element->parent;
                $element = $element->parent;
            }
            $path = array_reverse($path);
            $this->parentPath = $path;
        }

        return $this->parentPath;
    }


    /**
     * Set parents for elements in collection.
     *
     * @param $elements
     */
    public static function setParents($elements)
    {
        $elementsDict = [];
        foreach ($elements as $element) {
            $elementsDict[$element->id] = $element;
        }

        foreach ($elements as $element) {
            if (isset($elementsDict[$element->parent_id])) {
                $element->parent()->associate($elementsDict[$element->parent_id]);
            }
        }
    }


    /**
     * Make tree flat.
     *
     * @param $tree
     * @return Collection
     */
    public static function flattenTree($tree)
    {
        $elements = Collection::make([]);
        foreach ($tree as $element) {
            $elements[] = $element;
            foreach (self::flattenTree($element->children) as $child) {
                $elements[] = $child;
            }
        }

        return $elements;
    }
}
