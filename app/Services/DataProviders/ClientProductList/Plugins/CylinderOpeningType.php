<?php

namespace App\Services\DataProviders\ClientProductList\Plugins;

use App\Models\Product;
use App\Services\DataProviders\ClientProductList\ClientProductListPlugin;
use App\Services\Product\Attribute\CylinderOpeningType\CylinderOpeningTypeProvider;

class CylinderOpeningType implements ClientProductListPlugin
{
    public function __construct(
        private CylinderOpeningTypeProvider $cylinderOpeningTypeProvider
    ){}


    public function getForProductsList($products, array $additionalData = []): array
    {
        $array = [];

        foreach ($products as $element) {

            if (!$element->isCylinder()) {
              continue;
            }

            $result = $this->getData($element);

            if (!empty($result)) {
                $array[$element->id] = $result;
            }
        }

        return ['cylinder_opening_type' => $array];
    }


    private function getData(Product $product): array
    {
        $attrValue = $this->cylinderOpeningTypeProvider->getValueForProduct($product);

        return $attrValue->svg_path ? [
            'svg_path' => asset($attrValue->svg_path),
        ]: [];
    }
}
