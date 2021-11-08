<?php namespace App\Services\Repositories\Node;

use App\Models\Node;
use App\Services\RepositoryFeatures\Attribute\EloquentAttributeToggler;
use App\Services\RepositoryFeatures\Attribute\PositionUpdater;
use App\Services\RepositoryFeatures\Order\OrderScopesInterface;
use App\Services\RepositoryFeatures\Tree\TreeBuilderInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class EloquentNodeRepository
 * @package App\Services\Repositories\Node
 */
class EloquentNodeRepository
{
    const POSITION_STEP = 10;

    /**
     * @var EloquentAttributeToggler
     */
    private $attributeToggler;
    /**
     * @var OrderScopesInterface
     */
    private $orderScope;
    /**
     * @var TreeBuilderInterface
     */
    private $treeBuilder;
    /**
     * @var PositionUpdater
     */
    private $positionUpdater;

    /**
     * @param OrderScopesInterface $orderScope
     * @param TreeBuilderInterface $treeBuilder
     * @param EloquentAttributeToggler $attributeToggler
     * @param PositionUpdater $positionUpdater
     */
    public function __construct(
        OrderScopesInterface $orderScope,
        TreeBuilderInterface $treeBuilder,
        EloquentAttributeToggler $attributeToggler,
        PositionUpdater $positionUpdater
    ) {
        $this->orderScope = $orderScope;
        $this->treeBuilder = $treeBuilder;
        $this->attributeToggler = $attributeToggler;
        $this->positionUpdater = $positionUpdater;
    }


    public function newInstance(array $data = [])
    {
        return new Node($data);
    }


    public function findById($id)
    {
        return Node::find($id);
    }


    public function findByType($type, $published = false)
    {
        $query = Node::where('type', $type);
        if ($published) {
            $query->treePublished();
        }

        return $query->first();
    }


    public function allByType($type)
    {
        return Node::where('type', $type)->get();
    }


    public function delete(Node $node)
    {
        return $node->delete();
    }


    public function create(array $data)
    {
        if (empty($data['position'])) {
            $maxPosition = Node::where('parent_id', $data['parent_id'])->max('position');
            if (is_null($maxPosition)) {
                $maxPosition = 0;
            }
            $data['position'] = $maxPosition + self::POSITION_STEP;
        }

        return Node::create($data);
    }


    public function update(Node $node, array $data)
    {
        return $node->update($data);
    }


    public function getTreePath(Node $node)
    {
        return $this->treeBuilder->getTreePath(new Node(), $node->id);
    }


    public function getTree()
    {
        return $this->treeBuilder->getTree(new Node());
    }


    public function getCollapsedTree(Node $node = null)
    {
        return $this->treeBuilder->getCollapsedTree(new Node(), is_null($node) ? null : $node->id);
    }


    public function getParentVariants(Node $node = null, $rootName = null)
    {
        return $this->treeBuilder->getTreeVariants(new Node(), is_null($node) ? null : $node->id, $rootName);
    }


    public function updatePositions(array $positions)
    {
        $this->positionUpdater->updatePositions(new Node(), $positions);
    }


    public function toggleAttribute(Node $node, $attribute)
    {
        $this->attributeToggler->toggleAttribute($node, $attribute);

        return $node;
    }


    public function getTotal()
    {
        return Node::count();
    }


    public function treePublishedTopMenu()
    {
        $query = Node::where('menu_top', true);
        $this->orderScope->scopeOrdered($query);
        $query->treePublished();

        return $query->get();
    }


    public function treePublishedBottomMenu()
    {
        $query = Node::where('menu_bottom', true);
        $this->orderScope->scopeOrdered($query);
        $query->treePublished();

        return $query->get();
    }


    public function treePublishedWithAliases($aliases)
    {
        if (count($aliases) === 0) {
            return Collection::make([]);
        } else {
            return Node::query()->treePublished()->whereIn('alias', $aliases)->get();
        }
    }


    public function treePublishedChildrenFor(Node $node)
    {
        if (!is_null($node)) {
            $query = $node->children();
        } else {
            $query = Node::where('parent_id', null);
        }
        $query->treePublished();
        $this->orderScope->scopeOrdered($query);
        $children = $query->get();

        foreach ($children as $child) {
            $child->parent()->associate($node);
        }

        return $children;
    }
}
