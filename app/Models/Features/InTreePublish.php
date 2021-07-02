<?php namespace App\Models\Features;

/**
 * Class InTreePublish
 * Trait to handle "in_tree_publish" field. It is some sort of cache. This field will be calculated automatically.
 * Only this field will be enough to decide if element is published in tree (according to parents) or not.
 * First time need to run ::rebuildInTreePublish for model.
 *
 * @package App\Models\Feature
 */
trait InTreePublish
{
    /**
     * Published scope (check if parents are published too).
     * @param $query
     * @return mixed
     */
    public function scopeTreePublished($query)
    {
        return $query->where($this->getTable() . '.in_tree_publish', true);
    }


    /**
     * Rebuild publish in tree flag for all the model.
     */
    public static function rebuildInTreePublish()
    {
        self::rebuildElementsInTreePublish(self::whereNull('parent_id')->get(), true);
    }


    /**
     * Set "in tree publish" flag for element according to current publish data and parent.
     *
     * @param $element
     */
    private static function setInTreePublishForElement($element)
    {
        $parent = $element->parent()->first();
        if (is_null($parent)) {
            $parentInTreePublish = true;
        } else {
            $parentInTreePublish = $parent->in_tree_publish;
        }

        $element->in_tree_publish = (bool) $parentInTreePublish && (bool) $element->publish;
    }


    /**
     * Rebuild and save "in tree publish" flag for elements.
     *
     * @param $elements
     * @param boolean $parentInTreePublish
     */
    private static function rebuildElementsInTreePublish($elements, $parentInTreePublish)
    {
        $elementsToHandle = [];
        foreach ($elements as $element) {
            $elementsToHandle[] = ['element' => $element, 'parent_flag' => $parentInTreePublish];
        }


        $inTreePublishes = [];
        for ($i = 0; $i < count($elementsToHandle); $i += 1) {
            $element = $elementsToHandle[$i]['element'];
            $elementParentFlag = $elementsToHandle[$i]['parent_flag'];

            $elementFlag = (bool) $elementParentFlag && (bool)$element->publish;
            $inTreePublishes[$element->id] = $elementFlag;

            $subElementList = $element->children()->get();
            foreach ($subElementList as $subElement) {
                $elementsToHandle[] = ['element' => $subElement, 'parent_flag' => $elementFlag];
            }
        }


        \DB::beginTransaction();
        $table = (new self)->getTable();
        foreach ($inTreePublishes as $elementId => $elementInTreePublish) {
            \DB::table($table)->where('id', '=', $elementId)->update(['in_tree_publish' => $elementInTreePublish]);
        }
        \DB::commit();
    }


    protected static function bootInTreePublish()
    {
        self::saving(
            function (self $element) {
                self::setInTreePublishForElement($element);
                if ($element->exists) {
                    self::rebuildElementsInTreePublish($element->children()->get(), $element->in_tree_publish);
                }
            }
        );
    }
}
