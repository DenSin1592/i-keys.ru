<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServicePage;
use App\Services\Admin\Breadcrumbs\Breadcrumbs;
use App\Services\Repositories\Node\EloquentNodeRepository;
use App\Services\Repositories\ServicePage\EloquentServicePageRepository;

class ServicePagesController extends Controller
{
    private $nodeRepository;
    private $servicePageRepository;
    private $breadcrumbs;

    public function __construct(
        EloquentNodeRepository $nodeRepository,
        EloquentServicePageRepository $servicePageRepository,
        Breadcrumbs $breadcrumbs
    ) {
        $this->nodeRepository = $nodeRepository;
        $this->servicePageRepository = $servicePageRepository;
        $this->breadcrumbs = $breadcrumbs;
    }

    public function edit($nodeId)
    {
        $servicePage = $this->getServicePage($nodeId);
        $breadcrumbs = $this->breadcrumbs->getFor('structure_page.edit',$servicePage->node);

        return \View::make('admin.service_pages.edit')
            ->with('breadcrumbs', $breadcrumbs)
            ->with('servicePage', $servicePage)
            ->with('node', $servicePage->node)
            ->with('nodeTree', $this->nodeRepository->getCollapsedTree($servicePage->node));
    }

    public function update($nodeId)
    {
        $servicePage = $this->getServicePage($nodeId);
        $servicePage->fill(\Request::all());
        $servicePage->save();

        if (\Request::get('redirect_to') == 'index') {
            $redirect = \Redirect::route('cc.structure.index');
        } else {
            $redirect = \Redirect::route('cc.service-pages.edit', [$nodeId]);
        }
        return $redirect->with('alert_success', 'Страница обновлена');
    }


    private function getServicePage($nodeId)
    {
        $node = $this->nodeRepository->findById($nodeId);
        if (is_null($node)) {
            \App::abort(404, 'Node not found');
        }

        $servicePage = \TypeContainer::getContentModelFor($node);
        if ($servicePage instanceof ServicePage === false) {
            \App::abort(404, 'Text page not found');
        }

        return $servicePage;
    }
}
