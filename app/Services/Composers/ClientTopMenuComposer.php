<?php

namespace App\Services\Composers;

use App\Services\Composers\Features\NodeMenuBuilder;
use App\Services\Repositories\Node\EloquentNodeRepository;
use Illuminate\View\View;


class ClientTopMenuComposer
{
    use NodeMenuBuilder;


    public function __construct(
        private EloquentNodeRepository $nodeRepository
    ){}


    public function compose(View $view)
    {
        $nodeList = $this->nodeRepository->treePublishedTopMenu();
        $topMenu = $this->buildMenu($nodeList);
        $view->with('topMenu', $topMenu);
    }
}
