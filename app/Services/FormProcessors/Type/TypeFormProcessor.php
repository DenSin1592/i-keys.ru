<?php namespace App\Services\FormProcessors\Type;

use App\Services\FormProcessors\CreateUpdateFormProcessor;
use App\Services\FormProcessors\Features\AutoAlias;

class TypeFormProcessor extends CreateUpdateFormProcessor
{
    use AutoAlias;

    protected function prepareInputData(array $data)
    {
        $data = $this->setAutoAlias($data);

        return $data;
    }
}
