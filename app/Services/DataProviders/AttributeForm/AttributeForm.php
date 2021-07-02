<?php namespace App\Services\DataProviders\AttributeForm;

use App\Models\Attribute;

/**
 * Class AttributeForm
 * Data provider for attribute form.
 *
 * @package App\Services\DataProviders\AttributeForm
 */
class AttributeForm
{
    /** @var AttributeSubForm[] */
    private $subFormList = [];

    /**
     * Add sub form.
     *
     * @param AttributeSubForm $subForm
     */
    public function addSubForm(AttributeSubForm $subForm)
    {
        $this->subFormList[] = $subForm;
    }


    /**
     * Provide for data.
     *
     * @param Attribute $attribute
     * @param array $oldInput
     * @return array
     */
    public function provideDataFor(Attribute $attribute, array $oldInput)
    {
        $data = [
            'attribute' => $attribute,
            'category' => $attribute->category,
            'attribute_type' => ['variants' => $this->getAttributeTypeVariants()]
        ];

        foreach ($this->subFormList as $subForm) {
            $subFormData = $subForm->provideDataFor($attribute, $oldInput);
            $data = array_replace($data, $subFormData);
        }

        return $data;
    }


    /**
     * Provide only type data.
     *
     * @param Attribute $attribute
     * @param array $oldInput
     * @return array
     */
    public function provideTypeDataFor(Attribute $attribute, array $oldInput)
    {
        $data = [];
        foreach ($this->subFormList as $subForm) {
            if ($subForm->isTypeDataProvider()) {
                $subFormData = $subForm->provideDataFor($attribute, $oldInput);
                $data = array_replace($data, $subFormData);
            }
        }

        return $data;
    }


    /**
     * Get list of attribute type variants.
     *
     * @return array
     */
    private function getAttributeTypeVariants()
    {
        $variants = [];
        foreach (Attribute::getTypes() as $type) {
            $variants[$type] = Attribute::getTypeName($type);
        }

        return $variants;
    }
}
