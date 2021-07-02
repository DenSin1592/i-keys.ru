<?php namespace App\Services\FormProcessors\Category;

use App\Services\FormProcessors\CreateUpdateFormProcessor;
use App\Services\FormProcessors\Features\AutoAlias;

class CategoryFormProcessor extends CreateUpdateFormProcessor
{
    use AutoAlias;

    protected function prepareInputData(array $data)
    {
        $data = $this->setAutoAlias($data);

        return $data;
    }
}
