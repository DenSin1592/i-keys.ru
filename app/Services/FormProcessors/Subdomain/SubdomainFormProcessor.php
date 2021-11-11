<?php

namespace App\Services\FormProcessors\Subdomain;

use App\Services\FormProcessors\CreateUpdateFormProcessor;


class SubdomainFormProcessor extends CreateUpdateFormProcessor
{

    public function prepareInputData(array $data)
    {
        return $data;
    }

}
