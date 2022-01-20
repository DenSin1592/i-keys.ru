<?php

namespace App\Http\Controllers\Client;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Breadcrumbs\Container as BreadcrumbsContainer;
use App\Services\DataProviders\ClientProductList\ClientProductList;
use App\Services\Search\Rule\ProductsSearchRule;
use App\Services\Seo\MetaHelper;
use Illuminate\Pagination\LengthAwarePaginator;
use Request;


class SearchController extends Controller
{
    private const ELEMENTS_ON_PAGE = 12;

    public function __construct(
        private ClientProductList $productListProvider,
        private MetaHelper $metaHelper,
    ){}


    public function show()
    {
        try {
            $query = Request::get('query');
            $paginator = Product::search($query)
                ->rule(ProductsSearchRule::class)
                ->paginate(self::ELEMENTS_ON_PAGE);
        }catch (\Throwable $e){
            \Log::error($e->getMessage());
            resolve(Handler::class)->report($e);
            $paginator = new LengthAwarePaginator([], 0, self::ELEMENTS_ON_PAGE);
        }

        $productsData = $this->productListProvider->getProductListData($paginator->items());
        $breadcrumbs = $this->getBreadcrumbs();
        $metaData = $this->metaHelper->getRule()->metaForName('Поиск');

        return \View::make('client.search_page.show', [
            'metaData' => $metaData,
            'breadcrumbs' => $breadcrumbs,
            'productsData' => $productsData,
            'paginator' => $paginator,
            'query' => $query,
        ]);
    }


    private function getBreadcrumbs(): BreadcrumbsContainer
    {
        $breadcrumbs = resolve(\App\Services\Breadcrumbs\Factory::class)->init();
        $breadcrumbs->add('Главная', route('home'));
        $breadcrumbs->add('Поиск');
        return $breadcrumbs;
    }
}
