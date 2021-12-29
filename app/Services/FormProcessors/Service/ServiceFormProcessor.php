<?php

namespace App\Services\FormProcessors\Service;

use App\Services\FormProcessors\CreateUpdateFormProcessor;
use App\Services\FormProcessors\Features\AutoAlias;


class ServiceFormProcessor extends CreateUpdateFormProcessor
{

    use AutoAlias;

    private $subProcessorList = [];


    public function addSubProcessor(SubProcessor $subProcessor): void
    {
        $this->subProcessorList[] = $subProcessor;
    }


    protected function prepareInputData(array $data): array
    {
        $data = $this->setAutoAlias($data);
        $data = parent::prepareInputData($data);
        foreach ($this->subProcessorList as $subProcessor) {
            $data = $subProcessor->prepareInputData($data);
        }

        return $data;
    }


    protected function afterSuccess($instance, array $data): void
    {
        parent::afterSuccess($instance, $data);
        foreach ($this->subProcessorList as $subProcessor) {
            $subProcessor->save($instance, $data);
        }
    }
}
