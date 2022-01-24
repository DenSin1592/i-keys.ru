<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TextPage;
use App\Services\Admin\Breadcrumbs\Breadcrumbs;
use App\Services\Repositories\Node\EloquentNodeRepository;
use App\Services\Repositories\TextPage\EloquentTextPageRepository;

class TextPagesController extends Controller
{
    public function __construct(
        private EloquentNodeRepository $nodeRepository,
        private Breadcrumbs $breadcrumbs
    ) {}

    public function edit($nodeId)
    {
        $textPage = $this->getTextPage($nodeId);
        $breadcrumbs = $this->breadcrumbs->getFor('structure_page.edit',$textPage->node);

        return \View::make('admin.text_pages.edit')
            ->with('breadcrumbs', $breadcrumbs)
            ->with('textPage', $textPage)
            ->with('node', $textPage->node)
            ->with('nodeTree', $this->nodeRepository->getCollapsedTree($textPage->node));
    }

    public function update($nodeId)
    {
        $textPage = $this->getTextPage($nodeId);
        $textPage->fill(\Request::all());
        $textPage->save();

        if (\Request::get('redirect_to') == 'index') {
            $redirect = \Redirect::route('cc.structure.index');
        } else {
            $redirect = \Redirect::route('cc.text-pages.edit', [$nodeId]);
        }
        return $redirect->with('alert_success', 'Страница обновлена');
    }


    private function getTextPage($nodeId)
    {
        $node = $this->nodeRepository->findById($nodeId);
        if (is_null($node)) {
            \App::abort(404, 'Node not found');
        }

        $textPage = \TypeContainer::getContentModelFor($node);
        if ($textPage instanceof TextPage === false) {
            \App::abort(404, 'Text page not found');
        }

        return $textPage;
    }
}
