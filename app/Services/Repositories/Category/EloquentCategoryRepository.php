<?php

namespace App\Services\Repositories\Category;

use App\Models\Attribute;
use App\Models\Category;
use App\Services\RepositoryFeatures\Attribute\EloquentAttributeToggler;
use App\Services\RepositoryFeatures\Attribute\PositionUpdater;
use App\Services\RepositoryFeatures\Order\OrderScopesInterface;
use App\Services\RepositoryFeatures\Tree\TreeBuilderInterface;
use Illuminate\Database\Eloquent\Collection;


class EloquentCategoryRepository
{
    const POSITION_STEP = 10;


    public function __construct(
        private OrderScopesInterface $orderScope,
        private TreeBuilderInterface $treeBuilder,
        private PositionUpdater $positionUpdater,
        private EloquentAttributeToggler $attributeToggler
    ) {}

    public function newInstance(array $data = [])
    {
        return new Category($data);
    }

    public function newInstanceWith(Category $parent = null, array $data = [])
    {
        $category = $this->newInstance($data);
        if (null !== $parent) {
            $category->parent()->associate($parent);
        }

        return $category;
    }

    public function findById($id)
    {
        return Category::find($id);
    }

    public function findByCode1c($codeIc)
    {
        return Category::query()->where('code_1c', $codeIc)->first();
    }

    /**
     * @inheritDoc
     */
    public function findPublishedById($id): Category
    {
        return Category::where('id', $id)->treePublished()->first() ?? \App::abort(404, 'Category is not found');
    }

    /**
     * @inheritDoc
     */
    public function getPublishedTree(Category $category = null)
    {
        return $this->treeBuilder->getTree(
            new Category(),
            data_get($category, 'id'),
            function ($query) {
                return $query->treePublished();
            }
        );
    }

    public function create(array $data)
    {
        if (\Arr::get($data, 'position') === null) {
            $maxPosition = Category::where('parent_id', \Arr::get($data, 'parent_id'))->max('position');
            if (is_null($maxPosition)) {
                $maxPosition = 0;
            }
            $data['position'] = $maxPosition + self::POSITION_STEP;
        }

        return Category::create($data);
    }

    public function update(Category $category, array $data)
    {
        return $category->update($data);
    }

    public function delete(Category $category)
    {
        return $category->delete();
    }

    public function allForAttribute(Attribute $attribute)
    {
        $query = $attribute->categories();
        $this->orderScope->scopeOrdered($query);

        return $query->get();
    }

    public function updatePositions(array $positions)
    {
        $this->positionUpdater->updatePositions(new Category(), $positions);
    }

    public function toggleAttribute(Category $category, $attribute)
    {
        $this->attributeToggler->toggleAttribute($category, $attribute);
    }

    public function getTree(Category $category = null)
    {
        $collection = $this->treeBuilder->getTree(new Category(), \Arr::get($category, 'id'));

        $this->lazyLoadForTree($collection, 'products');
        return $collection;
    }

    private function lazyLoadForTree(&$collection, $relation)
    {
        if(is_null($collection)){
            return;
        }
        $collection->load($relation);
        foreach ($collection as $model){
            $this->lazyLoadForTree($model->children, $relation);
        }
    }

    public function getCollapsedTree(Category $category = null)
    {
        return $this->treeBuilder->getCollapsedTree(new Category(), is_null($category) ? null : $category->id);
    }

    public function getParentVariants(Category $category = null, $rootName = null)
    {
        return $this->treeBuilder->getTreeVariants(
            new Category(),
            is_null($category) ? null : $category->id,
            $rootName
        );
    }

    public function allByIds(array $ids)
    {
        if (count($ids) > 0) {
            $query = Category::query();
            $this->orderScope->scopeOrdered($query);
            $query->whereIn('id', $ids);
            $categories = $query->get();
        } else {
            $categories = Collection::make([]);
        }

        return $categories;
    }

    public function rooted()
    {
        $query = Category::whereNull('parent_id');
        $this->orderScope->scopeOrdered($query);

        return $query->get();
    }

    public function getDescendantsAndSelf(Category $category): Collection
    {
        $categories = $category->descendants()->get();
        $categories->add($category);

        return $categories;
    }

    public function getCatalogTypeVariants(): array
    {
        $variants = [];
        foreach (Category::getCatalogTypes() as $catalogType) {
            $variants[$catalogType] = trans("validation.model_attributes.category.catalog_type.{$catalogType}");
        }

        return $variants;
    }


    public function getElementsForHeaderMenu(): Collection
    {
        return Category::where('publish', true)->where('menu_top', true)->orderBy('position')->get();
    }


    public function getElementsForFooterMenu(): Collection
    {
        return Category::where('publish', true)->orderBy('position')->get();
    }


    public function getPublishedWithAliases(array $aliases): Collection
    {
        return Category::query()
            ->treePublished()
            ->whereIn('alias', $aliases)
            ->get() ?? Collection::make();

    }


    public function findCachedByAlias($alias)
    {
        static $categoriesKeyByAlias;

        if (!isset($categoriesKeyByAlias)) {
            $categoriesKeyByAlias = Category::query()
                ->whereNotNull('alias')
                ->get()->keyBy('alias');
        }

        return $categoriesKeyByAlias->get($alias);
    }
}
