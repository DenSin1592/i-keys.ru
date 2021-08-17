<?php

namespace App\Services\DataProviders\ProductForm\ProductSubForm;

use App\Models\Product;
use App\Services\DataProviders\AssociatedProductsForm\AssociatedProductsForm;
use App\Services\DataProviders\ProductForm\ProductSubForm;
use App\Services\Repositories\Product\EloquentProductRepository;

class RelatedProducts implements ProductSubForm
{
    private $productRepository;
    private $associatedProductsForm;

    /**
     * RelatedProducts constructor.
     * @param EloquentProductRepository $productRepository
     * @param AssociatedProductsForm $associatedProductsForm
     */
    public function __construct(
        EloquentProductRepository $productRepository,
        AssociatedProductsForm $associatedProductsForm
    ) {
        $this->productRepository = $productRepository;
        $this->associatedProductsForm = $associatedProductsForm;
    }

    /**
     * @inheritDoc
     */
    public function provideDataFor(Product $product, array $oldInput)
    {
        if (count($oldInput) > 0) {
            if (isset($oldInput['related_products']) && is_array($oldInput['related_products'])) {
                $relatedProductsData = $oldInput['related_products'];
            } else {
                $relatedProductsData = [];
            }
            $associatedRelatedProducts = $this->associatedProductsForm->buildForProductsData($relatedProductsData);
        } else {
            $relatedProducts = $this->productRepository->relatedProductsForProduct($product);
            $associatedRelatedProducts = $this->associatedProductsForm->buildForProducts($relatedProducts);
        }

        return ['associatedRelatedProducts' => $associatedRelatedProducts];
    }

}