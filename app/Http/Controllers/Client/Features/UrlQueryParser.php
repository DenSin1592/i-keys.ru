<?php

namespace App\Http\Controllers\Client\Features;

/**
 * Trait UrlQueryParser
 * @package App\Http\Controllers\Client\Features
 */
trait UrlQueryParser
{
    /**
     * Parse url query.
     * Get alias path and page.
     *
     * @param $query
     * @return array
     */
    private function parseUrlQuery($query)
    {
        $query = trim($query, '/');
        $queryArray = explode('/', $query);

        $parsedQuery = [
            'aliasPath' => $queryArray,
            'page' => null,
        ];
        if (count($queryArray) > 0) {
            $lastAlias = array_pop($queryArray);
            if (preg_match('/^page-([1-9]\d*)$/', $lastAlias, $matches)) {
                $page = $matches[1];
                if ($page == 1) {
                    \App::abort(404, 'Page 1 is not allowed in url');
                }
                $parsedQuery = [
                    'aliasPath' => $queryArray,
                    'page' => $page,
                ];
            }
        }

        return $parsedQuery;
    }
}