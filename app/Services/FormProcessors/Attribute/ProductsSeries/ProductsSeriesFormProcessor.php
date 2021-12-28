<?php

namespace App\Services\FormProcessors\Attribute\ProductsSeries;

use App\Services\FormProcessors\SubProcessor;
use App\Services\FormProcessors\CreateUpdateFormProcessor;


class ProductsSeriesFormProcessor extends CreateUpdateFormProcessor
{

    private $subProcessorList = [];


    public function addSubProcessor(SubProcessor $subProcessor)
    {
        $this->subProcessorList[] = $subProcessor;
    }


    protected function prepareInputData(array $data)
    {
        $data = parent::prepareInputData($data);
        foreach ($this->subProcessorList as $subProcessor) {
            $data = $subProcessor->prepareInputData($data);
        }

        return $data;
    }


    protected function afterSuccess($instance, array $data)
    {
        parent::afterSuccess($instance, $data);
        foreach ($this->subProcessorList as $subProcessor) {
            $subProcessor->save($instance, $data);
        }
    }
}
