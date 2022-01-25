<?php namespace App\Services\FormProcessors\Product;

use App\Models\Product;
use App\Services\FormProcessors\CreateUpdateFormProcessor;
use App\Services\FormProcessors\Features\AutoAlias;

class ProductFormProcessor extends CreateUpdateFormProcessor
{
    use AutoAlias;

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

    protected function afterSuccess($instance, array $data)
    {
        /** @var Product $instance */
        Product::withoutSyncingToSearch(
            function () use (&$instance, $data) {
                foreach ($this->subProcessorList as $subProcessor) {
                    $subProcessor->save($instance, $data);
                }
            }
        );
        $instance->refreshNameWithAttributes();
    }
}
