<?php


namespace App\Services\Validation\Subdomain;


use App\Services\Validation\AbstractLaravelValidator;

class SubdomainValidator extends AbstractLaravelValidator
{
    protected function getRules()
    {
        return [
            'name' => ['required', "unique:subdomains,name,{$this->currentId}"],
            'city_name' => ['required', "unique:subdomains,city_name,{$this->currentId}"],
        ];
    }
}
