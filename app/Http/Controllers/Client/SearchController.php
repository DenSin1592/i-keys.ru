<?php

namespace App\Http\Controllers\Client;

use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\Breadcrumbs\Container as BreadcrumbsContainer;
use App\Services\DataProviders\ClientProductList\ClientProductList;
use App\Services\Repositories\Category\EloquentCategoryRepository;
use App\Services\Search\Rule\ProductsSearchRule;
use App\Services\Seo\MetaHelper;
use Illuminate\Pagination\LengthAwarePaginator;
use Request;


class SearchController extends Controller
{
    private const DEFAULT_CATEGORY_FOR_SEARCH = 'all';
    private const ELEMENTS_ON_PAGE = 12;
    private string $query;
    private string $categoryForSearch;

    public function __construct(
        private ClientProductList $productListProvider,
        private MetaHelper $metaHelper,
    ){
        $this->query = Request::get('query','') ?? '';
        $this->categoryForSearch = Request::get('category_for_search', self::DEFAULT_CATEGORY_FOR_SEARCH) ?? self::DEFAULT_CATEGORY_FOR_SEARCH;
    }


    public function show()
    {
        try {
            $paginator = Product::search($this->query)
                ->rule(ProductsSearchRule::class);

            if($this->categoryForSearch !== self::DEFAULT_CATEGORY_FOR_SEARCH){
                $category = Category::query()->where('alias', '=', $this->categoryForSearch)->first();
                $categoryIds = resolve(EloquentCategoryRepository::class)->getPublishedTreeIds($category);
                $paginator = $paginator->whereIn('category_id', $categoryIds);

            }

            $paginator = $paginator->paginate(self::ELEMENTS_ON_PAGE);
        }catch (\Throwable $e){
            \Log::error($e->getMessage());
            resolve(Handler::class)->report($e);
            $paginator = new LengthAwarePaginator([], 0, self::ELEMENTS_ON_PAGE);
        }
        $paginator = $paginator->withQueryString();

        $productsData = $this->productListProvider->getProductListData($paginator->items());

        if($paginator->total() === 0 && $this->categoryForSearch !== self::DEFAULT_CATEGORY_FOR_SEARCH){
            Request::replace(['category_for_search' => self::DEFAULT_CATEGORY_FOR_SEARCH]);
            return redirect(route('search'));
        }

        $breadcrumbs = $this->getBreadcrumbs();
        $metaData = $this->metaHelper->getRule()->metaForName('Поиск');
        $tabsData = $this->getCategoryTabs();

        return \View::make('client.search_page.show', [
            'metaData' => $metaData,
            'breadcrumbs' => $breadcrumbs,
            'productsData' => $productsData,
            'paginator' => $paginator,
            'query' => $this->query,
            'tabsData' => $tabsData,
            'categoryForSearch' => $this->categoryForSearch,
        ]);
    }


    private function getCategoryTabs(): array
    {
        $tabsData = [];
        $tabsData[] = [
            'name' => 'Все',
            'url'=> route('search').'?query='.$this->query.'&category_for_search=all',
            'isActive' => $this->categoryForSearch === self::DEFAULT_CATEGORY_FOR_SEARCH
        ];

        $category = Category::query()
            ->where('menu_top', '=', true)
            ->where('publish', '=', true)
            ->orderBy('position')
            ->get();

        foreach ($category as $element){
            $tabsData[] = [
                'name' => $element->name,
                'url'=> route('search').'?query='.$this->query.'&category_for_search='.$element->alias,
                'isActive' => $this->categoryForSearch === $element->alias
            ];
        }

        return $tabsData;
    }


    private function getBreadcrumbs(): BreadcrumbsContainer
    {
        $breadcrumbs = resolve(\App\Services\Breadcrumbs\Factory::class)->init();
        $breadcrumbs->add('Главная', route('home'));
        $breadcrumbs->add('Поиск');
        return $breadcrumbs;
    }
}
