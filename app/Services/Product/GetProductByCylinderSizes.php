<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Services\Product\Attribute\SizesCylinder\DataProvider;
use Illuminate\Database\Eloquent\Builder;


class GetProductByCylinderSizes
{
    private Builder $productBuilder;

    public function __construct(
        private int $productId,
        private int $firstSize,
        private int $secondSize,
        private int $selectedSelectNumber,
    ){}


    public function getProductWhenChangingSizes(): Product
    {
        $product = Product::find($this->productId);
        $this->productBuilder = DataProvider::getBuilderByProductSeries($product);

        $newProduct = $this->geProductByTwoSizes($product);

        if(is_null($newProduct)){
            $newProduct = $this->getFirstProductByOneSize();
        }

        return $newProduct;
    }


    private function geProductByTwoSizes(Product $product): ?Product
    {
        $productBuilder = clone $this->productBuilder;

        return $productBuilder->where('attribute_allowed_values.value_first_size_cylinder', '=', $this->firstSize)
            ->where('attribute_allowed_values.value_second_size_cylinder', '=', $this->secondSize)
            ->select('products.*')
            ->first();
    }


    private function getFirstProductByOneSize(): Product
    {
        $productBuilder = clone $this->productBuilder;

        if($this->selectedSelectNumber === 1){
            $productBuilder = $productBuilder
                ->where('attribute_allowed_values.value_first_size_cylinder', '=', $this->firstSize);
        }else{
            $productBuilder = $productBuilder
                ->where('attribute_allowed_values.value_second_size_cylinder', '=', $this->secondSize);

        }

        return $productBuilder
            ->select('products.*')
            ->first();
    }
}
