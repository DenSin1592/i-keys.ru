<?php namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Node;
use App\Models\Service;
use App\Services\Breadcrumbs\Container as BreadcrumbsContainer;
use App\Services\Breadcrumbs\Factory as Breadcrumbs;
use App\Services\Repositories\Node\EloquentNodeRepository;
use App\Services\Seo\MetaHelper;
use Illuminate\View\View;

class ServicesController extends Controller
{
    public function __construct(
        private EloquentNodeRepository $nodeRepository,
        private MetaHelper $metaHelper,
        private Breadcrumbs $breadcrumbs
    ){}

    public function __invoke()
    {
        $node = $this->nodeRepository->findByType(Node::TYPE_SERVICES_PAGE);
        $page = \TypeContainer::getContentModelFor($node);
        $breadcrumbs = $this->getBreadcrumbs();
        $services = Service::where('publish', true)->orderBy('position')->get();
        $servicesFirstBlock = $services->take(2);
        $servicesSecondBlock = $services->splice(2);


        return \View::make('client.service.index')
            ->with('breadcrumbs', $breadcrumbs)
            ->with('authEditLink', route('cc.service-pages.edit', $page->node_id))
            ->with('metaData', $this->metaHelper->getRule()->metaForObject($page, $node->name))
            ->with('servicesFirstBlock', $servicesFirstBlock)
            ->with('servicesSecondBlock', $servicesSecondBlock);

    }

    private function getBreadcrumbs(): BreadcrumbsContainer
    {
        $breadcrumbs = $this->breadcrumbs->init();
        $breadcrumbs->add('Главная', route('home'));
        $breadcrumbs->add('Услуги');
        return $breadcrumbs;
    }
}
