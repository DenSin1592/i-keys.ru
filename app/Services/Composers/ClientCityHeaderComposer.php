<?php

namespace App\Services\Composers;

use App\Services\Subdomains\SubdomainsHelper;


class ClientCityHeaderComposer
{
    private $subdomainsHelper;

    public function __construct(SubdomainsHelper $subdomainsHelper)
    {
        $this->subdomainsHelper = $subdomainsHelper;
    }

    public function compose($view)
    {
        $view->with('currentCity', $this->subdomainsHelper->getSubdomainName());
    }
}
