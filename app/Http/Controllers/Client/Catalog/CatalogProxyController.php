<?php

namespace App\Http\Controllers\Client\Catalog;

use App\Exceptions\Handler;
use App\Http\Controllers\Client\Features\UrlQueryParser;
use App\Models\Category;
use App\Models\Product;
use App\Services\CatalogUrlPath\CatalogUrlPath;
use App\Services\CatalogUrlPath\WrongPath;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;


class CatalogProxyController
{
    use UrlQueryParser;

    public function __construct(
        private CatalogUrlPath $catalogUrlPath,
    ){}

    public function __invoke(string $url): View|JsonResponse
    {
        [$aliasPath, $inputData['page']] = $this->parseUrlQuery($url);
        $inputData['filterData'] = \Request::get('filter');
        $inputData['sort'] = \Request::get('sort', null);
        $inputData['productsView'] = \Helper::prepareProductsView(\Request::get('view'));

        try {
            $catalogPath = $this->catalogUrlPath->extractPath($aliasPath);
        } catch (WrongPath $e) {
            \App::abort(404, $e->getMessage());
        }
        $model = last($catalogPath);

        if ($model instanceof Category) {
            return \App::make(CatalogController::class)->getResponse($model, $inputData);
        }

        if ($model instanceof Product) {
            if (!is_null($inputData['page'])) {
                \App::abort(404, "Page is not allowed for product");
            }
            if (!is_null($inputData['sort'])) {
                \App::abort(404, "Sorting is not allowed for product");
            }
            if (!is_null($inputData['filterData'])) {
                \App::abort(404, "Filter is not allowed for product");
            }
            return \App::make(ProductsController::class)->getResponse($model);
        }

        \App::abort(404, 'Unknown model type');
    }
}
