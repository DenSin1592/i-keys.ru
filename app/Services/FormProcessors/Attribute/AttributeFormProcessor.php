<?php namespace App\Services\FormProcessors\Attribute;

use App\Services\FormProcessors\CreateUpdateFormProcessor;

class AttributeFormProcessor extends CreateUpdateFormProcessor
{
    /** @var SubProcessor[] */
    private $subProcessorList = [];

    /**
     * Add sub processor.
     *
     * @param SubProcessor $subProcessor
     */
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
