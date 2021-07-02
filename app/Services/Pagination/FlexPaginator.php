<?php namespace App\Services\Pagination;

use Arr;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Session;

/**
 * Class FlexPaginator
 * @package App\Services\Pagination
 */
class FlexPaginator
{
    private $availableLimits;
    private $request;

    public function __construct(array $availableLimits, Request $request)
    {
        $this->availableLimits = $availableLimits;
        $this->request = $request;
    }

    public function make(
        callable $paginatorCallback,
        $storePageKey = 'pagination-page',
        $storeLimitKey = 'pagination-limit'
    ) {
        $page = $this->request->get('page');
        if (null !== $page) {
            Session::put($storePageKey, $page);
        } else {
            $page = Session::get($storePageKey, 1);
        }

        $limit = $this->request->get('limit');
        $availableLimits = $this->availableLimits();
        if (in_array($limit, $availableLimits)) {
            Session::put($storeLimitKey, $limit);
        } else {
            $limit = Session::get($storeLimitKey, Arr::get($availableLimits, 0));
        }

        $paginatorStructure = $paginatorCallback($page, $limit);

        $paginator = new LengthAwarePaginator(
            $paginatorStructure['items']->all(),
            $paginatorStructure['total'],
            $paginatorStructure['limit'],
            $paginatorStructure['page']
        );

        $paginator->setPath($this->request->url());
        $paginator->appends('limit', $limit);

        return $paginator;
    }

    /**
     * Get list of available pagination limits.
     *
     * @return array
     */
    public function availableLimits()
    {
        return $this->availableLimits;
    }

}
