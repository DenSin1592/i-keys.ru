<?php namespace App\Services\Repositories\Product;

use App\Models\Category;
use App\Models\Product;
use App\Services\Repositories\Category\EloquentCategoryRepository;
use App\Services\RepositoryFeatures\Attribute\EloquentAttributeToggler;
use App\Services\RepositoryFeatures\Attribute\PositionUpdater;
use Illuminate\Database\Eloquent\Collection;

class EloquentProductRepository
{
    const POSITION_STEP = 10;

    private $positionUpdater;
    private $attributeToggler;
    private $categoryRepository;

    public function __construct(PositionUpdater $positionUpdater, EloquentAttributeToggler $attributeToggler, EloquentCategoryRepository $categoryRepository)
    {
        $this->positionUpdater = $positionUpdater;
        $this->attributeToggler = $attributeToggler;
        $this->categoryRepository = $categoryRepository;
    }


    public function allForCategory(Category $category)
    {
        return $category->products()->orderBy('position')->get();
    }

    /**
     * @param Product $product
     * @param bool $published
     * @return Collection
     */
    public function relatedProductsForProduct(Product $product, bool $published = false): Collection
    {
        $query = $product->relatedProducts();
        if ($published) {
            $query->join(
                'categories',
                'categories.id',
                '=',
                'products.category_id'
            )
                ->where('categories.in_tree_publish', true)
                ->where('products.publish', true);
        }

        $this->scopePositionOrdered($query);
        $query->select('products.*')->distinct();
        $this->scopeWithRelations($query);

        return $query->get();
    }

    /**
     * Get all products for root categories, grouped by root categories.
     *
     * @param null $excludeProductId
     * @return array
     */
    public function groupedForRootCategories($excludeProductId = null): Collection
    {
        $groupedProducts = Collection::make([]);

        $rootCategories = $this->categoryRepository->rooted();
        foreach ($rootCategories as $rootCategory) {
            $groupedProducts->push(
                [
                    'category' => $rootCategory,
                    'products' => $this->allWithinCategory($rootCategory->id, $excludeProductId),
                ]
            );
        }

        return $groupedProducts;
    }

    /**
     * @param array $productIds
     * @return Collection
     */
    public function sortedByIds(array $productIds): Collection
    {
        if (count($productIds) === 0) {
            return Collection::make([]);
        }

        $products = $this->byIds($productIds);
        $productsDictionary = $products->getDictionary();
        $sortedProducts = Collection::make([]);
        foreach ($productIds as $productId) {
            if (isset($productsDictionary[$productId])) {
                $sortedProducts->push($productsDictionary[$productId]);
            }
        }

        return $sortedProducts;
    }

    /**
     * @param $categoryId
     * @param null $excludeProductId
     * @return Collection
     */
    public function allWithinCategory($categoryId, $excludeProductId = null): Collection
    {
        $query = $this->getWithinCategoryQuery($categoryId, $excludeProductId);
        $this->scopeNameOrdered($query);
        $query->select('products.*')->distinct();
        $this->scopeWithRelations($query);

        return $query->get();
    }

    private function scopeNameOrdered($query)
    {
        return $query->orderBy('name', 'ASC');
    }

    /**
     * Get query to select products within category (category and children categories)
     *
     * @param $categoryId
     * @param null $excludeProductId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function getWithinCategoryQuery($categoryId, $excludeProductId = null)
    {
        $query = Product::query();
        if (is_null($categoryId)) {
            $query->where('products.category_id', $categoryId);
        } else {
            $query->leftJoin(
                'categories_ancestors',
                'categories_ancestors.descendant_id',
                '=',
                'products.category_id'
            )
                ->where(
                    function ($subQuery) use ($categoryId) {
                        $subQuery->orWhere('products.category_id', $categoryId);
                        $subQuery->orWhere('categories_ancestors.ancestor_id', $categoryId);
                    }
                );
        }

        if (!empty($excludeProductId)) {
            $query->where('products.id', '<>', $excludeProductId);
        }

        return $query;
    }

    public function allInCategoryByPage($categoryId, $page, $limit)
    {
        $query = Product::where('category_id', $categoryId)->orderBy('position');

        $total = $query->count();
        $items = $query->skip($limit * ($page - 1))
            ->take($limit)
            ->get();

        return [
            'page' => $page,
            'limit' => $limit,
            'items' => $items,
            'total' => $total,
        ];
    }

    public function updatePositions(array $positions)
    {
        $this->positionUpdater->updatePositions(new Product(), $positions);
    }


    public function toggleAttribute(Product $product, $attribute)
    {
        $this->attributeToggler->toggleAttribute($product, $attribute);
    }


    public function newInstance(array $data = [])
    {
        return new Product($data);
    }

    private function scopePositionOrdered($query)
    {
        return $query->orderBy('products.position', 'ASC');
    }

    public function getProductsForReviewBySearch($searchString, $page = 1, $limit = 20)
    {
        $searchString = trim($searchString);
        if ($searchString == '') {
            return [
                'items' => Collection::make([]),
                'total' => 0,
                'page' => $page,
                'limit' => $limit,
            ];
        }

        $query = Product::where('name', 'LIKE', '%' . $searchString . '%');

        $selectQuery = clone $query;
        $countQuery = clone $query;
        $products = $selectQuery
            ->skip($limit * ($page - 1))
            ->take($limit)
            ->get();
        $total = $this->selectProductCount($countQuery);

        return [
            'items' => $products,
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
        ];
    }

    private function selectProductCount($query)
    {
        $total = $query
            ->select(\DB::raw('COUNT(DISTINCT(products.id)) AS count'))
            ->pluck('count')
            ->first();

        return $total;
    }

    public function allInCategoryLvlByCategoryIds(array $categoryIds)
    {
        if (count($categoryIds) === 0) {
            return Collection::make([]);
        }

        $query = Product::query()->whereIn('category_id', $categoryIds);
        $this->scopePositionOrdered($query);

        return $query->get();
    }

    private function scopeWithRelations($query)
    {
        return $query->with(['category']);
    }

    /**
     * Get products by ids
     *
     * @param array $ids
     * @return Collection
     */
    public function byIds(array $ids): Collection
    {
        if (count($ids) === 0) {
            return Collection::make([]);
        }

        $query = Product::whereIn('id', $ids);
        $this->scopePositionOrdered($query);
        $this->scopeWithRelations($query);

        return $query->get();
    }

    public function newInstanceWithCategory(Category $category, array $data = [])
    {
        $product = $this->newInstance($data);
        $product->category()->associate($category);

        return $product;
    }

    public function create(array $data = [])
    {
        if (\Arr::get($data, 'position') === null) {
            $maxPosition = Product::where('category_id', \Arr::get($data, 'category_id'))->max('position');
            if (is_null($maxPosition)) {
                $maxPosition = 0;
            }
            $data['position'] = $maxPosition + self::POSITION_STEP;
        }

        return Product::create($data);
    }


    public function update(Product $product, array $data = [])
    {
        return $product->update($data);
    }


    public function delete(Product $product)
    {
        return $product->delete();
    }


    public function findById($id)
    {
        return Product::find($id);
    }

    /**
     * @param $code1c
     * @return Product|null
     */
    public function findByCode1c($code1c)
    {
        return Product::query()->where('code_1c', $code1c)->first();
    }
}
