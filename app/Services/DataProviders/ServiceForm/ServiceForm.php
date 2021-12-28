<?php namespace App\Services\DataProviders\ServiceForm;

use App\Models\Service;

/**
 * Class ServiceForm
 * Data provider for attribute form.
 *
 * @package App\Services\DataProviders\ServiceForm
 */
class ServiceForm
{
    /** @var ServiceSubForm[] */
    private $subFormList = [];

    /**
     * Add sub form.
     *
     * @param ServiceSubForm $subForm
     */
    public function addSubForm(ServiceSubForm $subForm)
    {
        $this->subFormList[] = $subForm;
    }


    /**
     * Provide for data.
     *
     * @param Service $service
     * @param array $oldInput
     * @return array
     */
    public function provideDataFor(Service $service, array $oldInput)
    {
        $data = [
            'service' => $service,
//            'category' => $service->category,
//            'attribute_type' => ['variants' => $this->getAttributeTypeVariants()]
        ];

        foreach ($this->subFormList as $subForm) {
            $subFormData = $subForm->provideDataFor($service, $oldInput);
            $data = array_replace($data, $subFormData);
        }

        return $data;
    }


    /**
     * Provide only type data.
     *
     * @param Service $attribute
     * @param array $oldInput
     * @return array
     */
    public function provideTypeDataFor(Service $attribute, array $oldInput)
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
    private function getServiceTypeVariants()
    {
        $variants = [];
        foreach (Service::getTypes() as $type) {
            $variants[$type] = Service::getTypeName($type);
        }

        return $variants;
    }
}
