<?php

namespace App\Services\FormProcessors\ProductTypePage;

use App\Models\ProductTypePage;
use App\Services\FormProcessors\CreateUpdateFormProcessor;
use App\Services\FormProcessors\Features\AutoAlias;

class ProductTypePageFormProcessor extends CreateUpdateFormProcessor
{
    use AutoAlias;

    /** @var SubProcessor[] */
    private $subProcessorList = [];

    /**
     * Add subProcessor.
     *
     * @param SubProcessor $subProcessor
     */
    public function addSubProcessor(SubProcessor $subProcessor)
    {
        $this->subProcessorList[] = $subProcessor;
    }

    protected function prepareInputData(array $data)
    {
        $data = $this->setAutoAlias($data);

        $nullIfZeroFields = ['parent_id', 'category_id'];
        foreach ($nullIfZeroFields as $field) {
            if (\Arr::get($data, $field, 0) == 0) {
                $data[$field] = null;
            }
        }

        foreach ($this->subProcessorList as $subProcessor) {
            $data = $subProcessor->prepareInputData($data);
        }

        return $data;
    }

    /**
     * @param $productTypePage
     * @param array $data
     */
    protected function afterSuccess($productTypePage, array $data)
    {
        /** @var ProductTypePage $productTypePage */
        foreach ($this->subProcessorList as $subProcessor) {
            $subProcessor->save($productTypePage, $data);
        }
    }
}