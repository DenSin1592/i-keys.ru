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

    public function index(): \Illuminate\Contracts\View\View
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

    public function show($alias)
    {
        $service = Service::where('alias', $alias)->first();
        $breadcrumbs = $this->getBreadcrumbs();
        $breadcrumbs->add($service->header, route('service.show', $service->alias));

        return \View::make('client.service.show')
            ->with('breadcrumbs', $breadcrumbs)
            ->with('authEditLink', route('cc.services.edit', $service->id))
            ->with('metaData', $this->metaHelper->getRule()->metaForObject($service))
            ->with('service', $service);
    }


    private function getBreadcrumbs(): BreadcrumbsContainer
    {
        $breadcrumbs = $this->breadcrumbs->init();
        $breadcrumbs->add('Главная', route('home'));
        $breadcrumbs->add('Услуги', route('services'));
        return $breadcrumbs;
    }
}
