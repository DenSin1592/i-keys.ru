<?php

namespace App\Services\Repositories\Product;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductTypePage;
use App\Services\Catalog\Filter\Filter\CatalogFilterFactory;
use App\Services\Catalog\ListSorting\SortingContainer;
use App\Services\Repositories\Category\EloquentCategoryRepository;
use App\Services\RepositoryFeatures\Attribute\EloquentAttributeToggler;
use App\Services\RepositoryFeatures\Attribute\PositionUpdater;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


class EloquentProductRepository
{
    const POSITION_STEP = 10;


    public function __construct(
        private PositionUpdater $positionUpdater,
        private EloquentAttributeToggler $attributeToggler,
        private EloquentCategoryRepository $categoryRepository,
        private CatalogFilterFactory $catalogFilterFactory,
        private SortingContainer $sortingContainer,
    ){}


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
     * @inheritDoc
     */
    public function getPublishedForCategoryInLvl($categoryId = null)
    {
        $query = Product::where('category_id', $categoryId);
        $this->scopePublished($query);
        $this->scopeNameOrdered($query);

        return $query->get();
    }

    private function scopePublished($query)
    {
        return $query->where('products.publish', true);
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

    public function groupedOnRootCategoriesFromAvailableList($excludeProductId = null): Collection
    {
        $groupedProducts = Collection::make([]);

        $rootCategories = $this->categoryRepository->rooted();
        foreach ($rootCategories as $rootCategory) {
            if($rootCategory->id === Category::COPIES_KEYS_ID
                || $rootCategory->id === Category::IMPORT_ID ){
                continue;
            }
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


    public function findByAlias(string $alias): ?Product
    {
        return Product::query()->where('alias', $alias)->first();
    }


    public function filterVariants(Category $category, $filterData = []): array
    {
        if (!is_array($filterData)) {
            $filterData = [];
        }
        $query = $this->getWithinCategoryPublishedQuery($category->id);

        return $this->catalogFilterFactory->getFilterByCategory($category)->getVariants($query, $filterData);
    }


    private function getWithinCategoryPublishedQuery($categoryId): Builder
    {
        $query = $this->getWithinCategoryQuery($categoryId);

        $query->join(
            'categories',
            'categories.id',
            '=',
            'products.category_id'
        )
            ->where('categories.in_tree_publish', true)
            ->where('products.publish', true);

        return $query;
    }


    public function getSortingVariants($sortingInput = null): array
    {
        return $this->sortingContainer->getSortingVariants($sortingInput);
    }


    public function publishedInCategoryTreeByPage(
        Category $category,
        int $page = 1,
        int $limit = 12,
        array $filterData = [],
        string $sorting = null
    ) : array
    {
        $query = $this->getWithinCategoryPublishedFilteredQuery($category, $filterData);

        return $this->getProductListStructure(
            $query,
            function ($q) use ($sorting) {
                $this->scopeOrdered($q);
                $this->sortingContainer->modifyQuery($q, $sorting);
            },
            $page,
            $limit
        );
    }


    private function getWithinCategoryPublishedFilteredQuery(Category $category, array $filterData = []): Builder
    {
        $query = $this->getWithinCategoryPublishedQuery($category->id);
        $this->catalogFilterFactory->getFilterByCategory($category)->modifyQuery($query, $filterData);

        return $query;
    }


    private function getProductListStructure($query, \Closure $sortingCallback, $page, $limit): array
    {
        $selectQuery = clone $query;
        $countQuery = clone $query;

        // sorting should be after modify query, because otherwise some filters could work incorrectly
        $sortingCallback($selectQuery);
        $this->scopeWithRelations($selectQuery);
        $products = $this->selectLimitedProducts($selectQuery, $page, $limit);
        $total = $this->selectProductCount($countQuery);

        return [
            'items' => $products,
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
        ];
    }


    private function scopeOrdered($query)
    {
        return $query->orderByRaw("(ISNULL(products.price) OR products.price=0) ASC");
    }


    private function selectLimitedProducts($query, $page, $limit): Collection
    {
        $query = $this->selectDistinctProductsQuery($query);

        $products = $query->skip($limit * ($page - 1))
            ->with(['images'])
            ->take($limit)
            ->get();

        return $products;
    }


    private function selectDistinctProductsQuery($query)
    {
        $query->select('products.*');
        if ($this->isJoined($query, 'product_type_page_associations')) {
            $query->addSelect(
                [
                    'product_type_page_associations.position AS product_type_page_associations_position',
                    'product_type_page_associations.name AS product_type_page_associations_name',
                ]
            );
        }

        return $query->distinct();
    }


    protected function isJoined($query, $tableName): bool
    {
        if ($query instanceof \Illuminate\Database\Eloquent\Builder) {
            $joins = $query->getQuery()->joins;
        } elseif ($query instanceof \Illuminate\Database\Eloquent\Relations\Relation) {
            $joins = $query->getBaseQuery()->joins;
        } else {
            throw new \InvalidArgumentException('Query has incorrect type');
        }

        $joined = false;
        if (is_array($joins)) {
            foreach ($joins as $join) {
                if (is_string($join->table) && $join->table == $tableName) {
                    $joined = true;
                    break;
                }
            }
        }

        return $joined;
    }


    public function markUpdateSearchForProduct(Product $product): void
    {
        if ($product->update_search) {
            return;
        }
        //TODO: сделать
        //\DB::table('products')->where('id', $product->id)->update(['update_search' => true]);
    }


    public function clearFilterVariants(Category $category, $filterData = [])
    {
        if (!is_array($filterData) || count($filterData) === 0) {
            return [];
        }
        $query = $this->getWithinCategoryPublishedQuery($category->id);

        return $this->catalogFilterFactory->getFilterByCategory($category)->clearFilterData($query, $filterData);
    }


    public function getDefaultSortingVariant()
    {
        return $this->sortingContainer->getDefaultSortingVariant();
    }


    public function allFilteredForProductType(
        Category $category,
        ProductTypePage $productTypePage,
        array $filterData = [],
        $sorting = null
    ) {
        $query = $this->getWithinCategoryQuery($category->id);
        $this->catalogFilterFactory->getFilterByCategory($category)->modifyQuery($query, $filterData);

        $this->scopeOrdered($query);
        // sorting should be after modify query, because otherwise some filters could work not correctly
        $this->sortingContainer->modifyQuery(
            $query,
            $sorting,
            ['productTypePage' => $productTypePage]
        );

        $query = $this->selectDistinctProductsQuery($query);

        return $query->get();
    }


    public function publishedFilteredForProductTypePageByPage(
        Category $category,
        ProductTypePage $productTypePage,
        $page = 1,
        $limit = 12,
        array $filterData = [],
        $sorting = null
    ) {
        $query = $this->getWithinCategoryPublishedFilteredQuery($category, $filterData);

        return $this->getProductListStructure(
            $query,
            function ($q) use ($sorting, $productTypePage) {
                $this->scopeOrdered($q);
                $this->sortingContainer->modifyQuery($q, $sorting, ['productTypePage' => $productTypePage]);
            },
            $page,
            $limit
        );
    }


    public function publishedManualForProductTypePageByPage(
        ProductTypePage $productTypePage,
        $page = 1,
        $limit = 12,
        $sorting = null
    ) {
        $query = $productTypePage->manualProducts();
        $query->join(
            'categories',
            'categories.id',
            '=',
            'products.category_id'
        )
            ->where('categories.in_tree_publish', true)
            ->where('products.publish', true);

        return $this->getProductListStructure(
            $query,
            function ($q) use ($sorting, $productTypePage) {
                $this->scopeOrdered($q);
                $this->sortingContainer->modifyQuery($q, $sorting, ['productTypePage' => $productTypePage]);
            },
            $page,
            $limit
        );
    }


    public function compareFilterData(Category $category, $baseFilterData, $filterData)
    {
        if (!is_array($filterData)) {
            $filterData = [];
        }

        if (!is_array($baseFilterData)) {
            $baseFilterData = [];
        }

        if (count($filterData) === 0 && count($baseFilterData) === 0) {
            return true;
        }

        $query = $this->getWithinCategoryPublishedQuery($category->id);

        return $this->catalogFilterFactory->getFilterByCategory($category)
            ->compareFilterData(
                $query,
                $baseFilterData,
                $filterData
            );
    }

    public function findPublishedById($id)
    {
        return Product::query()
            ->join(
                'categories',
                'categories.id',
                '=',
                'products.category_id'
            )
            ->where('categories.in_tree_publish', true)
            ->where('products.publish', true)
            ->where('products.id', $id)
            ->select('products.*')
            ->distinct()
            ->with('category')
            ->first();
    }


    public function getPublishedByIds(array $ids): Collection
    {
        if (count($ids) === 0) {
            return Collection::make([]);
        }

        return Product::query()
            ->join(
                'categories',
                'categories.id',
                '=',
                'products.category_id'
            )
            ->where('categories.in_tree_publish', true)
            ->where('products.publish', true)
            ->whereIn('products.id', $ids)
            ->select('products.*')
            ->distinct()
            ->with('category')
            ->get();
    }

    public function filterByNameAndCode1cInCategory(
        string $filterValue,
        $categoryId,
        $excludeProductId = null
    ): Collection {
        $query = $this->getWithinCategoryQuery($categoryId, $excludeProductId);
        $this->scopeFilterByNameAndCode1c($query, $filterValue);
        $this->scopeNameOrdered($query);
        $this->scopeWithRelations($query);

        return $query->select('products.*')
            ->distinct()
            ->get();
    }

    private function scopeFilterByNameAndCode1c($query, string $filterValue)
    {
        $filterValue = trim($filterValue);
        if ($filterValue !== '') {
            $query->where(
                function ($q) use ($filterValue) {
                    $q->where('products.name', 'like', "%{$filterValue}%")
                        ->orWhere('products.code_1c', 'like', "%{$filterValue}%");
                }
            );
        }

        return $query;
    }


    public function filterByNameAndCode1cAmongProducts(string $filterValue, array $productIds): Collection
    {
        if (count($productIds) === 0) {
            return Collection::make([]);
        }
        $query = Product::query()->whereIn('products.id', $productIds);
        $this->scopeFilterByNameAndCode1c($query, $filterValue);
        $this->scopeWithRelations($query);

        $productsDictionary = $query
            ->select('products.*')
            ->distinct()
            ->get()
            ->getDictionary();

        $sortedProducts = Collection::make([]);
        foreach ($productIds as $productId) {
            if (isset($productsDictionary[$productId])) {
                $sortedProducts->push($productsDictionary[$productId]);
            }
        }

        return $sortedProducts;
    }

}
