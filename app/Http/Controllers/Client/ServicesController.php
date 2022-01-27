<?php namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Node;
use App\Models\Service;
use App\Services\Breadcrumbs\Container as BreadcrumbsContainer;
use App\Services\Breadcrumbs\Factory as Breadcrumbs;
use App\Services\Repositories\Node\EloquentNodeRepository;
use App\Services\Seo\MetaHelper;
use Illuminate\Support\Facades\View;

class ServicesController extends Controller
{
    const COUNT_SERVICES_FOR_FIRST_BLOCK = 2;

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
        $servicesFirstBlock = $services->take(self::COUNT_SERVICES_FOR_FIRST_BLOCK);
        $servicesSecondBlock = $services->splice(self::COUNT_SERVICES_FOR_FIRST_BLOCK);

        return \View::make('client.service.index')
            ->with('breadcrumbs', $breadcrumbs)
            ->with('authEditLink', route('cc.service-pages.edit', $page->node_id))
            ->with('metaData', $this->metaHelper->getRule()->metaForObject($page, $node->name))
            ->with('servicesFirstBlock', $servicesFirstBlock)
            ->with('servicesSecondBlock', $servicesSecondBlock);
    }

    public function show($alias): \Illuminate\Contracts\View\View
    {
        $service = Service::where('alias', $alias)->first();

        if(is_null($service)) {
            return abort(404);
        }

        $service = $this->processServiceContent($service);

        return \View::make('client.service.show')
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

    private function processServiceContent(Service $service)
    {
        $breadcrumbs = $this->getBreadcrumbs();
        $breadcrumbs->add($service->header, route('service.show', $service->alias));
        $header = (is_null($service->header) || empty(trim($service->header))) ? $service->name : $service->header;
        $service->content = str_replace("{{H1}}", $header, $service->content);
        $service->content = str_replace("{{BREADCRUMBS}}",
                                        View::make('client.shared.breadcrumbs._breadcrumbs', ['breadcrumbs' => $breadcrumbs]),
                                        $service->content);

        return $service;
    }
}
