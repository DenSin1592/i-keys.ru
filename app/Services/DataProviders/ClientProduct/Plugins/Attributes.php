<?php

namespace App\Services\DataProviders\ClientProduct\Plugins;

use App\Models\Attribute;
use App\Models\Product;
use App\Services\DataProviders\ClientProduct\ClientProductPlugin;
use App\Services\Repositories\Attribute\EloquentAttributeRepository;
use JetBrains\PhpStorm\ArrayShape;


class Attributes implements ClientProductPlugin
{

    public function __construct(
        private EloquentAttributeRepository $attributeRepository
    ){}


    public function getForProduct(Product $product): array
    {
        $attributes = $this->attributeRepository->all();
        $productValues = $this->attributeRepository->getValues($product, $attributes);

        $attributesData = $this->getAttributesDataForProductValues($productValues);

        return ['attributesData' => $attributesData];
    }


    public function getAttributesDataForProductValues(array $productValues): array
    {

        $productAttributes = [];
        foreach ($productValues as $productValue) {

            if(!isset($productValue['value']) && is_null($productValue['value'])){
                continue;
            }

            $attributeId = $productValue['attribute']->id;
            $attributeName = $productValue['attribute']->name;

            $values = [];
            switch ($productValue['attribute']->attribute_type) {
                case Attribute::TYPE_STRING:
                case Attribute::TYPE_INTEGER:
                        $values[] = $this->addUnits($productValue['attribute'], $productValue['value']->value);
                    break;
                case Attribute::TYPE_DECIMAL:

                        $values[] =  $this->addUnits(
                                $productValue['attribute'],
                                number_format(
                                    $productValue['value']->value,
                                    $productValue['attribute']->decimal_scale,
                                    '.',
                                    ''
                                )
                            );

                    break;
                case Attribute::TYPE_SINGLE:

                        $values[] = $this->addUnits(
                                $productValue['attribute'],
                                $productValue['value']->allowedValue->value
                        );

                    break;
                case Attribute::TYPE_MULTIPLE:
//                    foreach ($productValue['values'] as $v) {
//                        $values[] = [
//                            'text' => $this->addUnits(
//                                $productValue['attribute'],
//                                $v->allowedValue->value
//                            ),
//                        ];
//                    }
                    break;
            }


            $productAttributeNote = [
                'id' => $attributeId,
                'name' => $attributeName,
                'values' => $values,
            ];

            if($productValue['value']->allowedValue instanceof Attribute\AllowedValue){
                $productAttributeNote['icon'] = $this->getIcon($productValue['value']->allowedValue);
            }



            if (count($productAttributeNote['values']) > 0) {
                $this->setTypeAttributes($productAttributes, $productAttributeNote);
            }
        }
        return $productAttributes;
    }

    /**
     * Provide attributes data for product search.
     *
     * @param Product $product
     * @return array
     */
    public function provideDataForSearch(Product $product): array
    {
        $attributes = $this->attributeRepository->all();
        $productValues = $this->attributeRepository->getValues($product, $attributes);

        $productAttributes = [];

        foreach ($productValues as $productValue) {
            $attributeName = $productValue['attribute']->name;

            $values = [];
            switch ($productValue['attribute']->attribute_type) {
                case Attribute::TYPE_STRING:
                case Attribute::TYPE_INTEGER:
                    if (!is_null($productValue['value'])) {
                        $values[] = $this->addUnits($productValue['attribute'], $productValue['value']->value);
                    }
                    break;
                case Attribute::TYPE_DECIMAL:
                    if (!is_null($productValue['value'])) {
                        $values[] = $this->addUnits(
                            $productValue['attribute'],
                            number_format(
                                $productValue['value']->value,
                                $productValue['attribute']->decimal_scale,
                                '.',
                                ''
                            )
                        );
                    }
                    break;
                case Attribute::TYPE_SINGLE:
                    if (!is_null($productValue['value'])) {
                        $values[] = $this->addUnits(
                            $productValue['attribute'],
                            $productValue['value']->allowedValue->value
                        );
                    }
                    break;
                case Attribute::TYPE_MULTIPLE:
                    foreach ($productValue['values'] as $v) {
                        $values[] = $this->addUnits(
                            $productValue['attribute'],
                            $v->allowedValue->value
                        );
                    }
                    break;
            }

            if (count($values) > 0) {
                $productAttributes[] = [
                    'name' => $attributeName,
                    'values' => $values,
                ];
            }
        }


        return $productAttributes;
    }


    private function addUnits(Attribute $attribute, $resultValue): string
    {
        $resultValue = $resultValue ?? '';
        if ($attribute->units !== '' && in_array($attribute->attribute_type, Attribute::getHasUnitsTypes())) {
            $resultValue .= ' ' . $attribute->units;
        }

        return $resultValue;
    }


    private function setTypeAttributes(array &$productAttributes, array $productAttributeNote): void
    {
        if(in_array($productAttributeNote['id'], Attribute\AttributeConstants::MAIN_ATTRIBUTES, false)){
            $productAttributes[Attribute\AttributeConstants::MAIN][$productAttributeNote['id']] = $productAttributeNote;
        }
        elseif(in_array($productAttributeNote['id'], Attribute\AttributeConstants::TECHNICAL_ATTRIBUTES, false)){
            $productAttributes[Attribute\AttributeConstants::OTHER][Attribute\AttributeConstants::TECHNICAL][$productAttributeNote['id']] = $productAttributeNote;
        }
        elseif(in_array($productAttributeNote['id'], Attribute\AttributeConstants::KEY_ATTRIBUTES, false)){
            $productAttributes[Attribute\AttributeConstants::OTHER][Attribute\AttributeConstants::KEY][$productAttributeNote['id']] = $productAttributeNote;
        }
        else{
            $productAttributes[Attribute\AttributeConstants::OTHER][Attribute\AttributeConstants::GENERAL][$productAttributeNote['id']] = $productAttributeNote;
        }
    }


    private function getIcon(Attribute\AllowedValue $value): string
    {
        return match ($value->attribute_id){
            Attribute\AttributeConstants::CYLINDER_OPENING_TYPE_ID => $value->getSpriteSvgHtml('class="product-attribute-media" width="83" height="20"'),
            Attribute\AttributeConstants::SECURITY_CLASS_ID => $value->getSpriteSvgHtml('class="product-attribute-media" width="26" height="30"', (int)$value->value),
            Attribute\AttributeConstants::COUNT_KEYS_IN_SET_ID => $value->getSpriteSvgHtml('class="product-attribute-media product-attribute-key" width="29" height="29"',  (int)$value->value <= 5 ? (int)$value->value : 5),
            default => $value->getSpriteSvgHtml(),
        };
    }
}
