<?php

namespace App\Services\Subdomains;

use App\Models\Subdomain;
use App\Services\Repositories\Subdomain\SubdomainRepositoryInterface;


class SeoHelper
{
    /*private $subdomainRepository;

    public function __construct(SubdomainRepositoryInterface $subdomainRepository)
    {
        $this->subdomainRepository = $subdomainRepository;
    }

    public function getSeoCountersFor(Subdomain $subdomain = null)
    {
        $counters = null;

        $subdomain = $subdomain ?: $this->subdomainRepository->getDefault();

        if (!is_null($subdomain)) {
            foreach (['google_analytics', 'yandex_metrika', 'live_internet'] as $field) {
                $counter = $subdomain->{$field};
                if ($field == 'live_internet') {
                    $counter = '';
                }

                $counters .= $counter;
            }
        }

        return $counters;
    }

    public function getRobotsTxtFor(Subdomain $subdomain = null)
    {
        $robotsTxt = null;

        $subdomain = $subdomain ?: $this->subdomainRepository->getDefault();

        if (!is_null($subdomain)) {
            $robotsTxt = $subdomain->robots_txt;
        }

        return $robotsTxt;
    }

    public function getMainPhoneNumber(Subdomain $subdomain = null)
    {
        $phoneNumber = '';
        $subdomain = $subdomain ?: $this->subdomainRepository->getDefault();
        if (!is_null($subdomain)) {
            $phoneNumber = $subdomain->phone_number_main;
        }

        return $phoneNumber;
    }

    public function getAdditionalPhoneNumber(Subdomain $subdomain = null)
    {
        return trim(\SettingGetter::get('phone_number_additional'));
    }*/
}
