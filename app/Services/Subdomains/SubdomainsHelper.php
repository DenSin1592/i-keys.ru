<?php

namespace App\Services\Subdomains;

use App\Models\Subdomain;
use App\Services\Repositories\Subdomain\EloquentSubdomainRepository;


class SubdomainsHelper
{
    public ?Subdomain $subdomain;
    public string $mainDomainName;

    public function __construct(
//        private Config $config,
//        private FormHelper $formHelper,
//        private Storage $fieldsStorage,
        private EloquentSubdomainRepository $subdomainRepository,
//        private SubdomainFieldRepositoryInterface $subdomainFieldRepository,
        private  UrlHelper $urlHelper,
//        private SeoHelper $seoHelper
    ){
        $parsedAddress = $this->urlHelper->parseHttpHostAndReturnSubdomenData(\Request::getHttpHost());
        $this->subdomain = $parsedAddress['subdomain_model'];
        $this->mainDomainName = $parsedAddress['main_domain_name'];
    }


    public function isDefaultSubdomain()
    {
        return $this->subdomain->id === Subdomain::DEFAULT_SUBDOMAIN_ID;
    }


    public function getDefaultSubdomain(): Subdomain
    {
        return $this->subdomainRepository->getDefault();
    }


    public function getSubdomainOrDefault(): Subdomain
    {
        return $this->subdomain ?? $this->getDefaultSubdomain();
    }


    public function getSubdomainName(): string
    {
        return $this->getSubdomainOrDefault()->city_name;
    }


    public function getOtherSubdomains()
    {
        return $this->subdomainRepository->allExcept($this->subdomain->id);
    }


    public function getUriFor($sourceUri, Subdomain $subdomain = null)
    {
        return $this->urlHelper->getUriFor($sourceUri, $subdomain);
    }



    /*public function subdomains()
    {
        return $this->subdomainRepository->all()->filter(
            function ($v) {
                return !$v->default;
            }
        );
    }*/

    /*public function subdomainVariants()
    {
        $variants = [];


        $defaultSubdomain = $this->getDefaultSubdomain();

        $variants[0] = $defaultSubdomain ? $defaultSubdomain->city_name : 'Основной домен';

        foreach ($this->subdomains() as $subdomain) {
            $name = $subdomain->city_name;
            $variants[$subdomain->id] = $name;
        }

        return $variants;
    }*/

    /*public function getConfigList()
    {
        return $this->config->getConfigList();
    }*/

    /*public function saveFields(array $formData = [])
    {
        $this->fieldsStorage->saveAll(array_get($formData, 'subdomain_fields', []));
    }*/

    /*public function saveField(\Eloquent $model, $modelId, $subdomainId, $fieldName, $fieldValue)
    {
        $this->fieldsStorage->save($model, $modelId, $subdomainId, $fieldName, $fieldValue);
    }*/

    /*public function getInputValue($modelUid, $modelId, Subdomain $subdomain, $field)
    {
        return $this->fieldsStorage->getFor($modelUid, $modelId, $subdomain, $field);
    }*/

    /*public function getValueFor(\Eloquent $model, $field, Subdomain $subdomain = null, $strict = true)
    {
        $value = null;
        $subdomain = $subdomain ?: $this->subdomain;

        if (!is_null($subdomain)) {
            try{
                $value = $this->fieldsStorage->getFor(
                    $this->config->modelUidFor($model),
                    object_get($model, 'id'),
                    $subdomain,
                    $field
                );
            } catch(\Exception $e) {

            }

            if ($strict) {
                return $value;
            }
        }

        return $value ?: $model->{$field};
    }*/

   /* public function editSubdomainsFieldsBlock($field, $inputType)
    {
        return $this->formHelper->editSubdomainsFieldsBlock($field, $inputType);
    }*/

   /* public function fieldBlock($field, $inputType, $value = null, $options = [])
    {
        return $this->formHelper->fieldBlock($field, $inputType, $value, $options);
    }*/

    /*public function modelFor($modelUid)
    {
        return $this->config->modelFor($modelUid);
    }*/

    /*public function modelUidFor(\Eloquent $model)
    {
        return $this->config->modelUidFor($model);
    }*/

    /*public function hasFieldFor(\Eloquent $model, $fieldName)
    {
        return $this->config->hasFieldFor($model, $fieldName);
    }*/

    /*public function getSeoCounters()
    {
        return $this->seoHelper->getSeoCountersFor($this->subdomain);
    }*/

    /*public function getRobotsTxt()
    {
        return $this->seoHelper->getRobotsTxtFor($this->subdomain);
    }*/

    /*public function parseHttpHostAndReturnSubdomenData($httpHost)
    {
        return $this->urlHelper->parseHttpHostAndReturnSubdomenData($httpHost);
    }*/

    /*public function getMainPhoneNumber($subdomain = null)
    {
        if (is_null($subdomain)) {
            $subdomain = $this->subdomain;
        }

        return $this->seoHelper->getMainPhoneNumber($subdomain);
    }*/

    /*public function getAdditionalPhoneNumber($subdomain = null)
    {
        if (is_null($subdomain)) {
            $subdomain = $this->subdomain;
        }

        return $this->seoHelper->getAdditionalPhoneNumber($subdomain);
    }*/

    /*public function getFieldValue($field)
    {
        return object_get($this->subdomain, $field);
    }*/

    /*public function getFieldValueForSubdomainOrDefault($field)
    {
        return object_get($this->getSubdomainOrDefault(), $field);
    }*/
}
