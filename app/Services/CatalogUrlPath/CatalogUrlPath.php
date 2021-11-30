<?php

namespace App\Services\CatalogUrlPath;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductTypePage;
use App\Services\Repositories\Category\EloquentCategoryRepository;
use App\Services\Repositories\Product\EloquentProductRepository;
use App\Services\Repositories\ProductTypePage\EloquentProductTypePageRepository;


class CatalogUrlPath
{
    public function __construct(
        private  EloquentCategoryRepository $categoryRepository,
        private  EloquentProductRepository $productRepository,
    ) {}


    public function extractPath(array $aliasPath): array
    {
        $catalogPath = $this->getCatalogPath($aliasPath);
        $this->checkCatalogPath($catalogPath);

        return $catalogPath;
    }


    private function getCatalogPath(array $aliasPath): array
    {
        // Get categories
        $categoryList = $this->categoryRepository->treePublishedWithAliases($aliasPath)->all();
        $categoryPath = $this->buildModelSequence($categoryList, $aliasPath);
        $aliasPath = $this->reduceAliasPath($aliasPath, count($categoryPath));

        // Get last category id
        if (count($categoryPath) > 0) {
            $lastCategoryId = $categoryPath[count($categoryPath) - 1]->id;
        } else {
            $lastCategoryId = null;
        }


        $productPath = [];
        if (count($aliasPath) > 0 && !is_null($lastCategoryId)) {
            $productAlias = array_pop($aliasPath);
            $product = $this->productRepository->findByAlias($productAlias);
            if (is_null($product) || !$product->publish) {
                throw new WrongPath("Product not found");
            }
            $productPath[] = $product;
        }

        if (count($aliasPath) > 0) {
            throw new WrongPath("Wrong alias path");
        }

        $catalogPath = [...$categoryPath, ...$productPath];

        return $catalogPath;
    }


    private function buildModelSequence(array $catalogModels, array $aliasPath): array
    {
        $modelPath = [];
        $parentModel = null;
        foreach ($aliasPath as $alias) {
            $parentCategoryId = is_null($parentModel) ? null : $parentModel->id;
            $matchedModel = null;
            foreach ($catalogModels as $model) {
                if ($model->parent_id === $parentCategoryId && $model->alias === $alias) {
                    $matchedModel = $model;
                    break;
                }
            }

            if (is_null($matchedModel)) {
                break;
            } else {
                $modelPath[] = $matchedModel;
                $parentModel = $matchedModel;
            }
        }

        return $modelPath;
    }



    private function reduceAliasPath(array $aliasPath, int $number)
    {
        for ($i = 0; $i < $number; $i += 1) {
            array_shift($aliasPath);
        }

        return $aliasPath;
    }



    private function checkCatalogPath(array $catalogPath): void
    {
        $catalogPathReverse = array_reverse($catalogPath);

        // Check and link chain
        for ($i = 0, $l = count($catalogPathReverse); $i < $l; $i += 1) {
            $element = $catalogPathReverse[$i];
            $parentElement = $catalogPathReverse[$i + 1] ?? null;
            if (is_null($parentElement)) {
                continue;
            }

            if ($element instanceof Product) {
                if ($parentElement instanceof Category && $parentElement->id == $element->category_id) {
                    $element->category()->associate($parentElement);
                } else {
                    throw new WrongPath("Product can not be associated with parent category");
                }
            } elseif ($element instanceof Category) {
                if ($element instanceof Category && $parentElement->id == $element->parent_id) {
                    $element->parent()->associate($parentElement);
                } else {
                    throw new WrongPath("Category can not be associated with parent category");
                }
            } else {
                throw new WrongPath();
            }
        }
    }
}
