<?php namespace App\Services\FormProcessors\Product;

use App\Services\FormProcessors\CreateUpdateFormProcessor;
use App\Services\FormProcessors\Features\AutoAlias;
use App\Services\FormProcessors\Product\Exception\Exception;

class ProductFormProcessor extends CreateUpdateFormProcessor
{
    use AutoAlias;

    /** @var SubProcessor[] */
    private $subProcessorList = [];

    public function create(array $data = [])
    {
        throw new Exception('Form does not support the creation of products');
    }

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
        $data = $this->setAutoAlias($data);
        if (\Arr::get($data, 'category_id') === '') {
            $data['category_id'] = null;
        }
        if (\Arr::get($data, 'price') === '') {
            $data['price'] = null;
        }

        return $data;
    }


    protected function afterSuccess($instance, array $data)
    {
        foreach ($this->subProcessorList as $subProcessor) {
            $subProcessor->save($instance, $data);
        }
    }
}
