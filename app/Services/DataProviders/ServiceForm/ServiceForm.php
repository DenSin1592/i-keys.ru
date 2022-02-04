<?php

namespace App\Services\DataProviders\ServiceForm;

use App\Models\Service;

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
        $data = ['service' => $service,];
        foreach ($this->subFormList as $subForm) {
            $subFormData = $subForm->provideDataFor($service, $oldInput);
            $data = array_replace($data, $subFormData);
        }

        return $data;
    }
}
