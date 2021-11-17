<?php

namespace App\Services\Pagination\PrettyPaginator;


/**
 * Paginator with pretty url: {base_url}/page/{n}
 */
class Paginator extends \Illuminate\Pagination\LengthAwarePaginator
{
    /**
     * Get the URL for a given page number.
     */
    public function url($page): string
    {
        if ($page <= 0) {
            $page = 1;
        }

        // Holds the paginator page name.
        $pageName = $this->getPageName();

        // An array to hold our parameters.
        $parameters = [];

        // If we have any extra query string key / value pairs that need to be added
        // onto the URL, we will put them in query string form and then attach it
        // to the URL. This allows for extra information like sortings storage.
        if (count($this->query) > 0) {
            $parameters = array_merge($this->query, $parameters);
        }

        $path = $this->path();
        $pathParts = explode('?', $path);

        $pageUrl = array_shift($pathParts);
        if ($page > 1) {
            $pageUrl .= '/' . $pageName . '-' . $page;
        }

        if (count($pathParts) > 0) {
            $pageUrl .= '?' . implode('?', $pathParts);

            if (count($parameters) > 0) {
                $pageUrl .= '&' . \Arr::query($parameters);
            }
        } else {
            if (count($parameters) > 0) {
                $pageUrl .= '?' . \Arr::query($parameters);
            }
        }

        $pageUrl .= $this->buildFragment();

        return $pageUrl;
    }
}
