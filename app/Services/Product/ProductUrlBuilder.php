<?php

namespace App\Services\Product;

use App\Models\Attribute\AttributeConstants;
use App\Models\Product;
use App\Services\Product\Attribute\SizesCylinder\DataProvider;
use Illuminate\Database\Eloquent\Builder;


class ProductUrlBuilder
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

        $newProduct = $this->geProductByTwoSizes($product);

        if(is_null($newProduct)){
            $newProduct = $this->getFirstProductByOneSize();
        }

        return $newProduct;
    }


    private function geProductByTwoSizes(Product $product): ?Product
    {
        $this->productBuilder = DataProvider::getBuilderByProductSeries($product);

        $productBuilder = clone $this->productBuilder;

        $product = $productBuilder->where('attribute_allowed_values.value_first_size_cylinder', '=', $this->firstSize)
            ->where('attribute_allowed_values.value_second_size_cylinder', '=', $this->secondSize)
            ->first();

        return $product;
    }


    private function getFirstProductByOneSize(): Product
    {
        if($this->selectedSelectNumber === 1){
            $product = $this->productBuilder
                ->where('attribute_allowed_values.value_first_size_cylinder', '=', $this->firstSize)
                ->first();
        }else{
            $product = $this->productBuilder
                ->where('attribute_allowed_values.value_second_size_cylinder', '=', $this->secondSize)
                ->first();
        }

        return $product;
    }
}
