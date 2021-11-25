<?php

namespace App\Http\Controllers\Client\Features;


trait UrlQueryParser
{

    /**
     * Get alias path and page.
     */
    private function parseUrlQuery(string $query): array
    {
        $query = trim($query, '/');
        $queryArray = explode('/', $query);

        if (count($queryArray) === 0) {
            \App::abort(404, 'Incorrect path to category');
        }

        $parsedQuery = [
            'aliasPath' => $queryArray,
            'page' => null,
        ];

        $parsedQuery = $this->getHandelDataNumberPage($queryArray) ?? $parsedQuery;

        if (count($parsedQuery['aliasPath']) === 0) {
            \App::abort(404, 'Incorrect path to category');
        }

        return [$parsedQuery['page'], $parsedQuery['aliasPath']];
    }


    private function getHandelDataNumberPage(array $queryArray): ?array
    {
        $lastAlias = array_pop($queryArray);
        if (!preg_match('/^page-([1-9]\d*)$/', $lastAlias, $matches)) {
            return null;
        }

        $page = $matches[1];
        if ($page === 1) {
            \App::abort(404, 'Page 1 is not allowed in url');
        }

        return [
            'aliasPath' => $queryArray,
            'page' => $page,
        ];
    }
}
