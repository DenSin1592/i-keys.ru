<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\MetaPage;
use App\Models\Node;
use App\Models\Product;
use App\Services\Breadcrumbs\Factory as Breadcrumbs;
use App\Services\DataProviders\ClientProductList\ClientProductList;
use App\Services\Repositories\Node\EloquentNodeRepository;
use App\Services\Search\Rule\ProductsSearchRule;
use App\Services\Seo\MetaHelper;
use Illuminate\Pagination\LengthAwarePaginator;
use Request;


class SearchController extends Controller
{
    private const ELEMENTS_ON_PAGE = 12;

    public function __construct(
//        EloquentNodeRepository $nodeRepository,
//        ClientProductList $productListProvider,
        private MetaHelper $metaHelper,
        private Breadcrumbs $breadcrumbs
    )
    {}

    public function show()
    {
        $breadcrumbs = $this->breadcrumbs->init();
        $breadcrumbs->add('Поиск');
        $metaData = $this->metaHelper->getRule()->metaForName('Поиск');

        return \View::make('client.search_page.show', [
            'metaData' => $metaData,
            'breadcrumbs' => $breadcrumbs,
        ]);


//        $query = Request::get('query');
//        if (!empty($query)) {
//            $paginator = Product::search($query)
//                ->rule(ProductsSearchRule::class)
//                ->paginate(self::ELEMENTS_ON_PAGE);
//
//        } else {
//            $paginator = new LengthAwarePaginator([], 0, self::ELEMENTS_ON_PAGE);
//        }


//        $additionalDataForMeta = ['withoutCanonical' => true, 'paginator' => $paginator];
//
//        $node = $this->nodeRepository->findByType(Node::TYPE_SEARCH_PAGE, true);
//        $breadcrumbs = $this->breadcrumbs->init();
//        if (!is_null($node)) {
//            /** @var MetaPage $searchPage */
//            $searchPage = \TypeContainer::getContentModelFor($node);
//            $searchPage->node()->associate($node);
//            $metaData = $this->metaHelper->getRule()->metaForObject($searchPage, $node->name, $additionalDataForMeta);
//            $breadcrumbs->add($node->name);
//        } else {
//            $searchPage = null;
//            $metaData = $this->metaHelper->getRule()->metaForName(self::DEFAULT_PAGE_NAME, $additionalDataForMeta);
//            $breadcrumbs->add(self::DEFAULT_PAGE_NAME);
//        }
//
//        $productsData = $this->productListProvider->getProductListData($paginator->items());
//
//        return view('client.search_page.show')
//            ->with('breadcrumbs', $breadcrumbs)
//            ->with('query', $query)
//            ->with('productsData', $productsData)
//            ->with('paginator', $paginator)
//            ->with('searchPage', $searchPage)
//            ->with($metaData)
//            ->with(
//                $node ? [
//                    'authEditLink' => route('cc.meta-pages.edit', $node->id),
//                    'currentNode' => $node,
//                ] : []
//            );
    }
}
