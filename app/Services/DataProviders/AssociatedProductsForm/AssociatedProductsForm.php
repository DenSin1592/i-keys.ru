<?php namespace App\Services\DataProviders\AssociatedProductsForm;

use App\Services\Repositories\Product\EloquentProductRepository;
use Illuminate\Database\Eloquent\Collection;

class AssociatedProductsForm
{
    private $productRepository;

    public function __construct(EloquentProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function buildForProducts(Collection $products)
    {
        $associatedProducts = [];
        foreach ($products as $product) {
            $associatedProducts[] = [
                'product' => $product,
                'position' => $product->pivot->position,
            ];
        }

        return $associatedProducts;
    }

    public function buildForProductsData(array $productsData)
    {
        $associatedProducts = [];
        $productIds = [];
        foreach ($productsData as $productData) {
            $productIds[] = $productData['product_id'];
        }
        $products = $this->productRepository->byIds($productIds);

        $products = $products->keyBy('id');
        foreach ($productsData as $productData) {
            $product = $products->get($productData['product_id']);
            if (is_null($product)) {
                continue;
            }
            $associatedProducts[] = [
                'product' => $product,
                'position' => \Arr::get($productData, 'position'),
            ];
        }

        return $associatedProducts;
    }
}
