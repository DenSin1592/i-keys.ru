<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePage;
use App\Services\Admin\Breadcrumbs\Breadcrumbs;
use App\Services\Repositories\HomePage\EloquentHomePageRepository;
use App\Services\Repositories\Node\EloquentNodeRepository;

class HomePagesController extends Controller
{
    private $nodeRepository;
    private $homePageRepository;
    private $breadcrumbs;

    public function __construct(
        EloquentNodeRepository $nodeRepository,
        EloquentHomePageRepository $homePageRepository,
        Breadcrumbs $breadcrumbs
    ) {
        $this->nodeRepository = $nodeRepository;
        $this->homePageRepository = $homePageRepository;
        $this->breadcrumbs = $breadcrumbs;
    }

    public function edit($nodeId)
    {
        $homePage = $this->getHomePage($nodeId);
        $breadcrumbs = $this->breadcrumbs->getFor('structure_page.edit', $homePage->node);

        return \View::make('admin.home_pages.edit')
            ->with('breadcrumbs', $breadcrumbs)
            ->with('homePage', $homePage)
            ->with('node', $homePage->node)
            ->with('nodeTree', $this->nodeRepository->getCollapsedTree($homePage->node));
    }

    public function update($nodeId)
    {
        $homePage = $this->getHomePage($nodeId);
        $homePage->fill(\Request::all());
        $homePage->save();

        if (\Request::get('redirect_to') == 'index') {
            $redirect = \Redirect::route('cc.structure.index');
        } else {
            $redirect = \Redirect::route('cc.home-pages.edit', [$nodeId]);
        }
        return $redirect->with('alert_success', 'Страница обновлена');
    }

    private function getHomePage($nodeId)
    {
        $node = $this->nodeRepository->findById($nodeId);
        $homePage = \TypeContainer::getContentModelFor($node);
        if ($homePage instanceof HomePage === false) {
            \App::abort(404, 'Home page not found');
        }

        return $homePage;
    }
}
