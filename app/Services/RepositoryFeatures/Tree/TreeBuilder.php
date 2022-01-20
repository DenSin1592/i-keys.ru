<?php namespace App\Services\RepositoryFeatures\Tree;

use App\Services\RepositoryFeatures\Order\OrderScopesInterface;

/**
 * Class TreeBuilder
 * @package App\Services\RepositoryFeatures\Tree
 */
class TreeBuilder implements TreeBuilderInterface
{
    /**
     * @var OrderScopesInterface
     */
    protected $orderScopes;

    /**
     * @inheritDoc
     */
    public function __construct(OrderScopesInterface $orderScopes)
    {
        $this->orderScopes = $orderScopes;
    }

    /**
     * @inheritDoc
     */
    public function getTree(\Eloquent $modelTemplate, $parentId = null, callable $filterCallback = null)
    {
        if (is_null($filterCallback)) {
            $filterCallback = function ($query) {
                // nothing
            };
        }

        $with = [];
        $with['children'] = function ($query) use (&$with, $filterCallback) {
            $filterCallback($query);
            $this->orderScopes->scopeOrdered($query);
            $query->with($with);
        };

        $query = $modelTemplate->query();
        if (null === $parentId) {
            $this->scopeRooted($query);

        } else {
            $this->scopeChildOf($query, $parentId);
        }

        $this->orderScopes->scopeOrdered($query);
        $rootQuery = $query->with($with);
        $filterCallback($rootQuery);

        return $rootQuery->get();
    }

    /**
     * @inheritDoc
     */
    public function getTreePath(\Eloquent $modelTemplate, $id)
    {
        $elementList = [];
        $elementParent = $modelTemplate->find($id);
        if (!is_null($elementParent)) {
            do {
                $elementList[] = $elementParent;
            } while (null !== $elementParent = $elementParent->parent()->first());
            $elementList = array_reverse($elementList);
        }

        return $elementList;
    }

    /**
     * @inheritDoc
     */
    public function getCollapsedTree(\Eloquent $modelTemplate, $id = null)
    {
        $path = $this->getTreePath($modelTemplate, $id);
        $pathIdList = [];
        foreach ($path as $category) {
            $pathIdList[] = $category->id;
        }

        $query = $modelTemplate->query();
        $this->scopeRooted($query);

        return $this->getTreeLvl($modelTemplate, $query, $pathIdList);
    }

    /**
     * @inheritDoc
     */
    private function getTreeLvl(\Eloquent $modelTemplate, $query, array $pathIdList)
    {
        $this->orderScopes->scopeOrdered($query);
        $result = $query->get();

        $lvl = [];
        foreach ($result as $category) {
            $lvlElement = ['element' => $category];

            $subQuery = $modelTemplate->query();
            $this->scopeChildOf($subQuery, $category->id);
            $children = $this->getTreeLvl($modelTemplate, $subQuery, $pathIdList);

            if (in_array($category->id, $pathIdList)) {
                $lvlElement['children'] = $children;
            } else {
                $lvlElement['children'] = [];
            }
            $lvlElement['hasChildren'] = count($children) > 0;
            $lvl[] = $lvlElement;
        }

        return $lvl;
    }

    /**
     * @inheritDoc
     */
    public function getTreeVariants(\Eloquent $modelTemplate, $currentId, $root = null)
    {
        $tree = $this->getTree($modelTemplate);
        $lvlModelList = [];
        $flatten = function ($tree, $lvl = 0) use ($currentId, &$flatten, &$lvlModelList) {
            foreach ($tree as $treeElement) {
                if ($currentId == $treeElement->id) {
                    continue;
                }
                $piece = new \stdClass();
                $piece->model = $treeElement;
                $piece->lvl = $lvl;
                $lvlModelList[] = $piece;

                if (isset($treeElement->children)) {
                    $flatten($treeElement->children, $lvl + 1);
                }
            }
        };
        $flatten($tree);

        $variantsArray = [];
        if (!is_null($root)) {
            $variantsArray[null] = $root;
            $startLvl = 1;
        } else {
            $startLvl = 0;
        }

        foreach ($lvlModelList as $lvlModel) {
            $variantName = '';
            for ($i = 0; $i < $startLvl + $lvlModel->lvl; $i += 1) {
                $variantName .= '-';
            }
            if (!empty($variantName)) {
                $variantName .= ' ';
            }
            $variantName .= $lvlModel->model->name;
            $variantsArray[$lvlModel->model->id] = $variantName;
        }

        return $variantsArray;
    }


    public function getListTreeVariantsForCurrentId(\Eloquent $modelTemplate, $currentId, $root = null)
    {
        $tree = $this->getTree($modelTemplate);

        $lvlModelList = [];
        $flatten = function ($tree, $lvl = 0) use ($currentId, &$flatten, &$lvlModelList) {
            foreach ($tree as $treeElement) {
                if ($currentId != $treeElement->id && $lvl == 0) {
                    continue;
                }
                $piece = new \stdClass();
                $piece->model = $treeElement;
                $piece->lvl = $lvl;
                $lvlModelList[] = $piece;

                if (isset($treeElement->children)) {
                    $flatten($treeElement->children, $lvl + 1);
                }

            }
        };
        $flatten($tree);

        $variantsArray = [];
        if (!is_null($root)) {
            $variantsArray[null] = $root;
            $startLvl = 1;
        } else {
            $startLvl = 0;
        }

        foreach ($lvlModelList as $lvlModel) {
            $variantName = '';
            for ($i = 0; $i < $startLvl + $lvlModel->lvl; $i += 1) {
                $variantName .= '-';
            }
            if (!empty($variantName)) {
                $variantName .= ' ';
            }
            $variantName .= $lvlModel->model->name;
            $variantsArray[$lvlModel->model->id] = $variantName;
        }

        return $variantsArray;
    }


    /**
     * @inheritDoc
     */
    public function scopeRooted($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * @inheritDoc
     */
    public function scopeChildOf($query, $id)
    {
        return $query->where('parent_id', $id);
    }

    /**
     * @inheritdoc
     */
    public function getChildIds(\Eloquent $modelTemplate, $rootId = null)
    {
        $idsList = [];

        $queue = [];
        $addToQueue = function ($list) use (&$queue) {
            foreach ($list as $c) {
                array_push($queue, $c);
            }
        };

        $query = $modelTemplate->query();
        if (is_null($rootId)) {
            $this->scopeRooted($query);
        } else {
            $query->where('id', $rootId);
        }

        $rooted = $query->get();
        $addToQueue($rooted);

        while (!is_null($c = array_pop($queue))) {
            $idsList[] = $c->id;

            $childrenQuery = $c->children();
            $addToQueue($childrenQuery->get());
        }

        return $idsList;
    }

    private function getParentAttributes(\Eloquent $modelTemplate, $id, $attribute)
    {
        $attributes = [];

        /** @var mixed $modelInstance */
        $modelInstance = $modelTemplate->find($id);

        if (!is_null($modelInstance)) {
            $attributes = [];
            if ($p = $modelInstance->parent()->first()) {
                $attributes = $this->getParentAttributes($modelTemplate, $p->id, $attribute);
                $attributes[] = $p->{$attribute};
            }
        }

        return $attributes;
    }

    /**
     * @inheritdoc
     */
    public function getParentIds(\Eloquent $modelTemplate, $id)
    {
        return $this->getParentAttributes($modelTemplate, $id, 'id');
    }

    /**
     * @inheritdoc
     */
    public function getRoot(\Eloquent $modelTemplate, $id)
    {
        $ids = $this->getParentIds($modelTemplate, $id);
        $rootId = count($ids) > 0 ? $ids[0] : $id;

        return $modelTemplate->find($rootId);
    }
}
