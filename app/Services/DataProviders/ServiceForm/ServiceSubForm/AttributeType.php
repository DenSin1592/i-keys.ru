<?php namespace App\Services\DataProviders\AttributeForm\AttributeSubForm;

use App\Models\Attribute;
use App\Services\DataProviders\AttributeForm\AttributeSubForm;

/**
 * Class AttributeType
 * Abstract data provider for specific attribute type.
 *
 * @package App\Services\DataProviders\AttributeForm\AttributeSubForm
 */
abstract class AttributeType implements AttributeSubForm
{
    public function provideDataFor(Attribute $attribute, array $oldInput)
    {
        $attributeType = $this->extractAttributeType($attribute, $oldInput);

        return $this->provideTypeDataFor($attributeType, $attribute, $oldInput);
    }


    /**
     * Extract attribute type.
     *
     * @param Attribute $attribute
     * @param array $oldInput
     * @return string
     */
    private function extractAttributeType(Attribute $attribute, array $oldInput)
    {
        $attributeType = null;
        if (isset($oldInput['attribute_type'])) {
            $attributeType = $oldInput['attribute_type'];
        } else {
            if (is_null($attribute->attribute_type)) {
                $attributeType = \Arr::get(Attribute::getTypes(), 0);
            } else {
                $attributeType = $attribute->attribute_type;
            }
        }

        return $attributeType;
    }


    /**
     * Attribute data according to type.
     *
     * @param $attributeType
     * @param Attribute $attribute
     * @param array $oldInput
     * @return mixed
     */
    abstract protected function provideTypeDataFor($attributeType, Attribute $attribute, array $oldInput);


    public function isTypeDataProvider()
    {
        return true;
    }
}
