<?php

namespace App\Services\Repositories\ProductTypePage;

use App\Models\ProductTypePage;
use App\Services\RepositoryFeatures\Attribute\EloquentAttributeToggler;
use App\Services\RepositoryFeatures\Attribute\PositionUpdater;
use App\Services\RepositoryFeatures\Order\OrderScopesInterface;
use App\Services\RepositoryFeatures\Tree\TreeBuilderInterface;
use Illuminate\Database\Eloquent\Collection;


class EloquentProductTypePageRepository
{
    const POSITION_STEP = 10;


    public function __construct(
        private OrderScopesInterface $orderScope,
        private TreeBuilderInterface $treeBuilder,
        private EloquentAttributeToggler $attributeToggler,
        private PositionUpdater $positionUpdater
    ) {}

    public function newInstance(array $data = [])
    {
        return new ProductTypePage($data);
    }

    /**
     * @param $id
     * @return ProductTypePage|null
     */
    public function findById($id)
    {
        return ProductTypePage::find($id);
    }

    public function findPublishedById($id)
    {
        return ProductTypePage::query()->treePublished()->find($id);
    }

    public function findOrNew($id, array $data = []): ProductTypePage
    {
        $productTypePage = $this->findById($id);
        if (is_null($productTypePage)) {
            $productTypePage = $this->newInstance($data);
        }

        return $productTypePage;
    }

    public function delete(ProductTypePage $productTypePage)
    {
        return $productTypePage->delete();
    }

    public function create(array $data): ProductTypePage
    {
        if (empty($data['position'])) {
            $maxPosition = ProductTypePage::where('parent_id', $data['parent_id'])->max('position');
            if (is_null($maxPosition)) {
                $maxPosition = 0;
            }
            $data['position'] = $maxPosition + self::POSITION_STEP;
        }

        return ProductTypePage::create($data);
    }

    public function update(ProductTypePage $productTypePage, array $data)
    {
        return $productTypePage->update($data);
    }


    public function getTreePath(ProductTypePage $productTypePage)
    {
        return $this->treeBuilder->getTreePath(new ProductTypePage(), $productTypePage->id);
    }


    public function getTree()
    {
        return $this->treeBuilder->getTree(new ProductTypePage());
    }


    public function getCollapsedTree(ProductTypePage $productTypePage = null)
    {
        return $this->treeBuilder->getCollapsedTree(
            new ProductTypePage(),
            is_null($productTypePage) ? null : $productTypePage->id
        );
    }


    public function getParentVariants(ProductTypePage $productTypePage = null, $rootName = null)
    {
        return $this->treeBuilder->getTreeVariants(
            new ProductTypePage(),
            is_null($productTypePage) ? null : $productTypePage->id,
            $rootName
        );
    }


    public function updatePositions(array $positions)
    {
        $this->positionUpdater->updatePositions(new ProductTypePage(), $positions);
    }


    public function toggleAttribute(ProductTypePage $productTypePage, $attribute): ProductTypePage
    {
        $this->attributeToggler->toggleAttribute($productTypePage, $attribute);

        return $productTypePage;
    }


    public function getTotal()
    {
        return ProductTypePage::count();
    }


    public function treePublishedInLeftMenu(): Collection
    {
        $query = ProductTypePage::where('in_left_menu', true);
        $this->orderScope->scopeOrdered($query);
        $query->treePublished();

        return $query->get();
    }


    public function treePublishedWithAliases($aliases): Collection
    {
        if (count($aliases) === 0) {
            return Collection::make([]);
        } else {
            return ProductTypePage::query()->treePublished()->whereIn('alias', $aliases)->get();
        }
    }

    public function treePublishedChildrenFor(ProductTypePage $productTypePage): Collection
    {
        if (!is_null($productTypePage)) {
            $query = $productTypePage->children();
        } else {
            $query = ProductTypePage::where('parent_id', null);
        }
        $query->treePublished();
        $this->orderScope->scopeOrdered($query);
        $children = $query->get();

        foreach ($children as $child) {
            $child->parent()->associate($productTypePage);
        }

        return $children;
    }


    public function all()
    {
        $query = ProductTypePage::query();
        $this->orderScope->scopeOrdered($query);

        return $query->get();
    }

    public function allPublished(): Collection
    {
        $query = ProductTypePage::query()->treePublished();
        $this->orderScope->scopeOrdered($query);

        return $query->get();
    }

    public function allPublishedWithFilter(): Collection
    {
        $query = ProductTypePage::query()
            ->where('product_list_way', ProductTypePage::WAY_FILTERED)
            ->whereNotNull('filter_query')
            ->treePublished();
        $this->orderScope->scopeOrdered($query);

        return $query->get();
    }

    public function getPublishedWithAliases(array $aliases): Collection
    {
        return ProductTypePage::query()
            ->treePublished()
            ->whereIn('alias', $aliases)
            ->get() ?? Collection::make();

    }

    /**
     * @inheritDoc
     */
    public function getPublishedTree()
    {
        return $this->treeBuilder->getTree(
            new ProductTypePage(),
            null,
            function ($query) {
                return $query->treePublished();
            }
        );
    }


    public function getModelsByCategoryId(int $id): Collection
    {
        return ProductTypePage::query()
            ->where('publish', true)
            ->where('category_id', $id)
            ->orderBy('position')
            ->get();
    }
}
