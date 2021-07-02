<?php namespace App\Services\FormProcessors\Product\SubProcessor;

use App\Models\Product;
use App\Services\FormProcessors\Product\SubProcessor;
use App\Services\Repositories\Attribute\EloquentAttributeRepository;

class Attributes implements SubProcessor
{
    private $attributeRepository;

    public function __construct(EloquentAttributeRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }


    public function prepareInputData(array $data)
    {
        return $data;
    }


    public function save(Product $product, array $data)
    {
        $attributesListData = \Arr::get($data, 'attributes');
        if (!is_array($attributesListData)) {
            $attributesListData = [];
        }

        $attributes = $this->attributeRepository->allowedForCategory($product->category);
        foreach ($attributes as $attribute) {
            $attributeData = \Arr::get($attributesListData, $attribute->id);
            $this->attributeRepository->saveValue(
                $product,
                $attribute,
                $attributeData
            );
        }
    }
}
