<?php

namespace App\Services\DataProviders\ClientProductList\Plugins;

use App\Models\Attribute\AllowedValue;
use App\Models\Product;
use App\Services\DataProviders\ClientProductList\ClientProductListPlugin;
use App\Services\Product\Attribute\Color\DataProvider;
use Illuminate\Database\Eloquent\Collection;


class Colors implements ClientProductListPlugin
{
    public function __construct(
        private DataProvider $dataProvider
    ){}


    public function getForProductsList($products, array $additionalData = []): array
    {
        $array = [];

        foreach ($products as $element) {
            $result = [];
            if ($element->isCylinder()) {
                $result = $this->getDataForCylinder($element);
            }

            if(empty($result)){
                $result = $this->getDefaultData($element);
            }

            if (!empty($result)) {
                $array[$element->id] = $result;
            }
        }

        return ['colors' => $array];
    }


    private function getDataForCylinder($product): array
    {
        $products = $this->dataProvider->getBuilderByCylinderSeries($product)
            ->orderBy('attribute_allowed_values.value')
            ->select('products.*', 'attribute_allowed_values.id as attr_id', 'attribute_allowed_values.value as attr_value')
            ->get();

        return $this->getFinishData($product, $products);
    }


    private function getDefaultData($product): array
    {
        $products = $this->dataProvider->getCollectionOneProductWithAttrValue($product);

        return $this->getFinishData($product, $products);
    }


    private function getFinishData(Product $product, Collection $products): array
    {
        if ($products->count() === 0) {
            return [];
        }

        $allowedValuesIds = [];
        foreach ($products as $element) {
            $allowedValuesIds[$element->attr_id] = $element->attr_id;
        }

        $allowedValues = AllowedValue::query()->find($allowedValuesIds);

        $colors = [];
        foreach ($products as $element) {
            $isActive = $product->id === $element->id;

            $colors[] = [
                'product_id' => $element->id,
                'attr_value' => $element->attr_value,
                'isActive' => $isActive,
                'imgPath' => (static function() use ($element, $allowedValues){
                    foreach ($allowedValues as $value){
                        if($element->attr_id === $value->id){
                            return $value->getImgSourcePath('icon', null, 'no-image-40x40.png');
                        }
                    }
                    return $value->getImgSourcePath('', null, 'no-image-40x40.png');
                })(),

            ];
        }

        return $colors;
    }

}
