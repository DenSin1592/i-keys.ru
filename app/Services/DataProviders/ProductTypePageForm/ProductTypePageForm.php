<?php namespace App\Services\DataProviders\ProductTypePageForm;

use App\Models\Category;
use App\Models\ProductTypePage;
use App\Services\Catalog\FilterUrlParser\Exception\IncorrectCategory;
use App\Services\Catalog\FilterUrlParser\FilterUrlParser;
use App\Services\Repositories\Category\EloquentCategoryRepository;
use App\Services\Repositories\Product\EloquentProductRepository;
use App\Services\Repositories\ProductTypePage\EloquentProductTypePageRepository;
use App\Services\Repositories\ProductTypePageAssociation\EloquentProductTypePageAssociationRepository;
use Illuminate\Database\Eloquent\Collection;

class ProductTypePageForm
{
    private $productTypePageRepository;
    private $productTypePageAssociationRepository;
    private $categoryRepository;
    private $productRepository;
    private $filterUrlParser;


    public function __construct(
        EloquentProductTypePageRepository $productTypePageRepository,
        EloquentCategoryRepository $categoryRepository,
        EloquentProductRepository $productRepository,
        EloquentProductTypePageAssociationRepository $productTypePageAssociationRepository,
        FilterUrlParser $filterUrlParser
    ) {
        $this->productTypePageRepository = $productTypePageRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->productTypePageAssociationRepository = $productTypePageAssociationRepository;
        $this->filterUrlParser = $filterUrlParser;
    }

    public function provideDataFor(ProductTypePage $productTypePage, array $oldInput): array
    {
        if (!empty($oldInput['filtered_products_opened'])) {
            $filteredData = $this->getFilteredProductsData($productTypePage, $oldInput);
        } else {
            $filteredData = [
                'products' => Collection::make([]),
                'associations' => [],
            ];
        }

        if (!empty($oldInput['manual_products_opened'])) {
            $manualData = $this->provideDataForManualTree($productTypePage, $oldInput);
        } else {
            $manualData = [];
        }

        $data = [
            'productTypePage' => $productTypePage,
            'parentVariants' => $this->productTypePageRepository->getParentVariants($productTypePage, '[Корень]'),
            'productTypePageTree' => $this->productTypePageRepository->getCollapsedTree($productTypePage),
            'filteredData' => $filteredData,
            'manualData' => $manualData,
            'categoryVariants' => $this->categoryRepository->getParentVariants(null)
        ];

        return $data;
    }

    public function provideDataForManualTree(ProductTypePage $productTypePage, array $oldInput)
    {
        $oldAssociationsData = \Arr::get($oldInput, 'product_associations.manual');
        if (!is_array($oldAssociationsData)) {
            $oldAssociationsData = [];
        }
        $preLoadedManualAssociations = $this->getPreLoadedAssociations($productTypePage, $oldAssociationsData);

        if (!empty($oldInput['manual_products_opened'])) {
            $productIds = \Arr::get($oldInput, 'manual_products');
            $products = $this->productRepository->byIds($productIds);
        } else {
            $products = $productTypePage->manualProducts;
            $productIds = $products->pluck('id')->toArray();
        }

        $activeCategoriesIds = $this->extractCategoriesIdsFromProducts($products);
        $productsGroupByCategories = $this->productRepository
            ->allInCategoryLvlByCategoryIds($activeCategoriesIds)
            ->groupBy('category_id');

        return [
            'categories' => $this->categoryRepository->rooted(),
            'product_ids' => $productIds,
            'active_categories_ids' => $activeCategoriesIds,
            'associations' => $preLoadedManualAssociations,
            'products_group_by_categories' => $productsGroupByCategories,
        ];
    }

    public function provideDataForManualSubTree(ProductTypePage $productTypePage, Category $category)
    {
        $preLoadedManualAssociations = $this->getPreLoadedAssociations($productTypePage);

        $activeCategoriesIds = $this->extractCategoriesIdsFromProducts($productTypePage->manualProducts);
        $productsGroupByCategories = $this->productRepository
            ->allInCategoryLvlByCategoryIds(
                array_merge($activeCategoriesIds, [$category->id])
            )
            ->groupBy('category_id');

        return [
            'product_ids' => $productTypePage->manualProducts->pluck('id')->toArray(),
            'active_categories_ids' => $activeCategoriesIds,
            'associations' => $preLoadedManualAssociations,
            'products_group_by_categories' => $productsGroupByCategories,
        ];
    }


    private function getFilteredProductsData(ProductTypePage $productTypePage, array $oldInput)
    {
        $filteredProducts = $this->getProductsByFilterUrl(
            $productTypePage,
            (string)\Arr::get($oldInput, 'filter_query', $productTypePage->filter_query)
        );

        $oldAssociationsData = \Arr::get($oldInput, 'product_associations.filtered');
        if (!is_array($oldAssociationsData)) {
            $oldAssociationsData = [];
        }
        $preLoadedFilteredAssociations = $this->getPreLoadedAssociations($productTypePage, $oldAssociationsData);

        return [
            'products' => $filteredProducts,
            'associations' => $preLoadedFilteredAssociations,
        ];
    }

    /**
     * Get pre-loaded associations for current page.
     *
     * @param ProductTypePage $productTypePage
     * @param array $data
     * @return array
     */
    private function getPreLoadedAssociations(ProductTypePage $productTypePage, array $data = [])
    {
        $products = $this->productRepository->byIds(array_keys($data))->all();

        return $this->productTypePageAssociationRepository->groupedByProductsForPage($productTypePage, $products);
    }

    /**
     * Extract categories ids from products.
     *
     * @param $products
     * @return array
     */
    private function extractCategoriesIdsFromProducts(Collection $products)
    {
        $categoriesIds = [];
        $categories = [];

        foreach ($products as $product) {
            if (!in_array($product->category_id, $categoriesIds)) {
                $categoriesIds[] = $product->category_id;
                $categories[] = $product->category;
            }
        }

        for ($i = 0; $i < count($categories); $i += 1) {
            $category = $categories[$i];
            if (!is_null($category->parent_id) && !in_array($category->parent_id, $categoriesIds)) {
                $categoriesIds[] = $category->parent_id;
                $categories[] = $category->parent;
            }
        }

        return $categoriesIds;
    }


    /**
     * @param ProductTypePage $productTypePage
     * @param string $filterUrl
     * @return Collection
     */
    public function getProductsByFilterUrl(ProductTypePage $productTypePage, string $filterUrl)
    {
        try {
            $parsedFilterString = $this->filterUrlParser->parseFilterUrl($filterUrl);
            $filteredProducts = $this->productRepository->allFilteredForProductType(
                $parsedFilterString['category'],
                $productTypePage,
                $parsedFilterString['filterData'],
                $parsedFilterString['sort']
            );
        } catch (IncorrectCategory $e) {
            $filteredProducts = Collection::make([]);
        }

        return $filteredProducts;
    }

    /**
     * Get products for product type page
     *
     * @param ProductTypePage $productTypePage
     * @return Collection|mixed
     */
    public function getProductsForProductTypePage(ProductTypePage $productTypePage)
    {
        switch ($productTypePage->product_list_way) {
            case ProductTypePage::WAY_FILTERED:
                $products = $this->getProductsByFilterUrl(
                    $productTypePage,
                    (string)$productTypePage->filter_query
                );
                break;
            case ProductTypePage::WAY_MANUAL:
                $products = $productTypePage->manualProducts;
                break;
            default:
                $products = Collection::make([]);
                break;
        }

        return $products;
    }
}
