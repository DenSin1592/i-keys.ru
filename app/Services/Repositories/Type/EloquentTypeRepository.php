<?php namespace App\Services\Repositories\Type;

use App\Models\Category;
use App\Models\Type;
use App\Services\RepositoryFeatures\Attribute\EloquentAttributeToggler;
use App\Services\RepositoryFeatures\Attribute\PositionUpdater;
use App\Services\RepositoryFeatures\Order\OrderScopesInterface;
use App\Services\RepositoryFeatures\Tree\TreeBuilderInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class EloquentTypeRepository
 * @package App\Services\Repositories\Type
 */
class EloquentTypeRepository
{
    const POSITION_STEP = 10;

    private $orderScope;
    private $treeBuilder;
    private $positionUpdater;
    private $attributeToggler;

    public function __construct(
        OrderScopesInterface $orderScope,
        TreeBuilderInterface $treeBuilder,
        PositionUpdater $positionUpdater,
        EloquentAttributeToggler $attributeToggler
    ) {
        $this->orderScope = $orderScope;
        $this->treeBuilder = $treeBuilder;
        $this->positionUpdater = $positionUpdater;
        $this->attributeToggler = $attributeToggler;
    }

    public function newInstance(array $data = [])
    {
        return new Type($data);
    }

    public function newInstanceWith(Type $parent = null, array $data = [])
    {
        $type = $this->newInstance($data);
        if (null !== $parent) {
            $type->parent()->associate($parent);
        }

        return $type;
    }

    public function findById($id)
    {
        return Type::find($id);
    }

    public function create(array $data)
    {
        if (\Arr::get($data, 'position') === null) {
            $maxPosition = Type::where('parent_id', \Arr::get($data, 'parent_id'))->max('position');
            if (is_null($maxPosition)) {
                $maxPosition = 0;
            }
            $data['position'] = $maxPosition + self::POSITION_STEP;
        }

        return Type::create($data);
    }

    public function update(Type $type, array $data)
    {
        return $type->update($data);
    }

    public function delete(Type $type)
    {
        return $type->delete();
    }

    public function updatePositions(array $positions)
    {
        $this->positionUpdater->updatePositions(new Type(), $positions);
    }

    public function toggleAttribute(Type $type, $attribute)
    {
        $this->attributeToggler->toggleAttribute($type, $attribute);
    }

    public function getTree(Type $type = null)
    {
        return $this->treeBuilder->getTree(new Type(), \Arr::get($type, 'id'));
    }

    public function getCollapsedTree(Type $type = null)
    {
        return $this->treeBuilder->getCollapsedTree(new Type(), is_null($type) ? null : $type->id);
    }

    public function getParentVariants(Type $type = null, $rootName = null)
    {
        return $this->treeBuilder->getTreeVariants(
            new Type(),
            is_null($type) ? null : $type->id,
            $rootName
        );
    }

    public function getCategoryVariants(Type $type = null, $rootName = null)
    {
        return $this->treeBuilder->getTreeVariants(
            new Category(),
            is_null($type) ? null : $type->id,
            $rootName
        );
    }

    public function allByIds(array $ids)
    {
        if (count($ids) > 0) {
            $query = Type::query();
            $this->orderScope->scopeOrdered($query);
            $query->whereIn('id', $ids);
            $types = $query->get();
        } else {
            $types = Collection::make([]);
        }

        return $types;
    }

    public function rooted()
    {
        $query = Type::whereNull('parent_id');
        $this->orderScope->scopeOrdered($query);

        return $query->get();
    }

    public function getDescendantsAndSelf(Type $type)
    {
        $types = $type->descendants()->get();
        $types->add($type);

        return $types;
    }
}
