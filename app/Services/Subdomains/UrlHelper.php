<?php

namespace App\Services\Subdomains;

use App\Models\Subdomain;
use App\Services\Repositories\Subdomain\EloquentSubdomainRepository;


class UrlHelper
{

    public function __construct(EloquentSubdomainRepository $subdomainRepository)
    {
        $this->subdomainRepository = $subdomainRepository;
    }


    public function parseHttpHostAndReturnSubdomenData($httpHost)
    {
        if (\Str::startsWith($httpHost, '192.168.1.99') || \Str::startsWith($httpHost, '127.0.0.1') ) {
            return [
                'main_domain_name' => $httpHost,
                'subdomain_name' => null,
                'subdomain_model' => null
            ];
        }

        $addressParts = explode('.', $httpHost);

        if (count($addressParts) < 3) {
            return [
                'main_domain_name' => $httpHost,
                'subdomain_name' => null,
                'subdomain_model' => null,
            ];
        }

        $subdomainNames = array_diff($addressParts, array_slice($addressParts, -2));

        if ($subdomainNames[0] === 'www') {
            array_shift($subdomainNames);
        }

        if(empty($subdomainNames)){
            return [
                'main_domain_name' => $httpHost,
                'subdomain_name' => null,
                'subdomain_model' => null,
            ];
        }

        $subdomainName = $subdomainNames[0];
        $mainDomainName = implode('.', array_slice($addressParts, -2));

        $subdomainModel = $this->subdomainRepository->findByName($subdomainName);

        return [
            'main_domain_name' => $mainDomainName,
            'subdomain_name' => $subdomainName,
            'subdomain_model' => $subdomainModel
        ];
    }


    public function getUriFor($sourceUri, Subdomain $subdomain = null)
    {
        $sourceUri = trim($sourceUri);

        if (empty($sourceUri)) {
            return $sourceUri;
        }

        if (!(parse_url($sourceUri)['scheme'])) {
            $sourceUri = \Request::getScheme() . '://' . $sourceUri;
        }

        $targetUrl = null;

        $parts = parse_url($sourceUri);

        $scheme = $parts['scheme'] ?? null;
        $host = $parts['host'] ?? null;
        $port = $parts['port'] ?? null;
        $path = $parts['path'] ?? null;
        $query = $parts['query'] ?? null;
        $fragment = $parts['fragment'] ?? null;

        $mainDomainName = $this->parseHttpHostAndReturnSubdomenData($host)['main_domain_name'];

        if ($scheme) {
            $targetUrl = $scheme . '://';
        }

        if (is_null($subdomain)) {
            $targetUrl .= $mainDomainName;

        } else {
            $targetUrl .= $subdomain->name . '.' . $mainDomainName;
        }

        if ($port) {
            $targetUrl .= ':' . $port;
        }

        if ($path) {
            $targetUrl .= '/' . trim($path, '/');
        }

        if ($query) {
            $targetUrl .= '?' . $query;
        }

        if ($fragment) {
            $targetUrl .= '#' . $fragment;
        }

        return $targetUrl;
    }
}
