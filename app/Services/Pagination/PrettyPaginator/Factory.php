<?php

namespace App\Services\Pagination\PrettyPaginator;


class Factory
{

    public function makeFromCallback(callable $callback, string $baseUrl, ?int $page, int $limit, array $queryData = []): Paginator
    {
        if (is_null($page)) {
            $page = 1;
        }

        $paginatorStructure = $callback($page, $limit);

        return $this->makeFromPaginatorStructure($paginatorStructure, $baseUrl, $queryData);
    }


    public function makeFromPaginatorStructure(array $paginatorStructure, string $baseUrl, array $queryData = []): Paginator
    {
        $paginator = new Paginator(
            $paginatorStructure['items']->all(),
            $paginatorStructure['total'],
            $paginatorStructure['limit'],
            $paginatorStructure['page'],
            $queryData
        );
        $paginator->setPath($baseUrl);

        if ($paginator->count() === 0 && $paginatorStructure['page'] > 1) {
            \App::abort(404, 'Incorrect page number');
        }

        $queryData = array_filter($queryData, static fn($e) => !empty($e));

        $paginator->appends($queryData);

        return $paginator;
    }
}
