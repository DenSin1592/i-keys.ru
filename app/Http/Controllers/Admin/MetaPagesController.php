<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MetaPage;
use App\Services\Admin\Breadcrumbs\Breadcrumbs;
use App\Services\Repositories\Node\EloquentNodeRepository;

class MetaPagesController extends Controller
{
    private $nodeRepository;
    private $breadcrumbs;

    public function __construct(
        EloquentNodeRepository $nodeRepository,
        Breadcrumbs $breadcrumbs
    ) {
        $this->nodeRepository = $nodeRepository;
        $this->breadcrumbs = $breadcrumbs;
    }

    public function edit($nodeId = null)
    {
        $metaPage = $this->getMetaPage($nodeId);
        $breadcrumbs = $this->breadcrumbs->getFor('structure_page.edit', $metaPage->node);

        return \View::make('admin.meta_pages.edit')
            ->with('breadcrumbs', $breadcrumbs)
            ->with('metaPage', $metaPage)
            ->with('node', $metaPage->node)
            ->with('nodeTree', $this->nodeRepository->getCollapsedTree($metaPage->node));
    }

    public function update($nodeId = null)
    {
        $metaPage = $this->getMetaPage($nodeId);
        $metaPage->fill(\Request::all());
        $metaPage->save();

        if (\Request::get('redirect_to') == 'index') {
            $redirect = \Redirect::route('cc.structure.index');
        } else {
            $redirect = \Redirect::route('cc.meta-page.edit', [$nodeId]);
        }
        return $redirect->with('alert_success', 'Страница обновлена');
    }

    private function getMetaPage($nodeId)
    {
        $node = $this->nodeRepository->findById($nodeId);
        if (is_null($node)) {
            \App::abort(404, 'Node not found');
        }
        $metaPage = \TypeContainer::getContentModelFor($node);
        if ($metaPage instanceof MetaPage === false) {
            \App::abort(404, 'Meta page not found');
        }

        return $metaPage;
    }
}
