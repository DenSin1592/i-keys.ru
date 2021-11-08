<?php

namespace App\Services\Composers;

use App\Services\Composers\Features\NodeMenuBuilder;
use App\Services\Repositories\Node\EloquentNodeRepository;
use Illuminate\View\View;


class ClientBottomMenuComposer
{
    use NodeMenuBuilder;


    public function __construct(
        private EloquentNodeRepository $nodeRepository
    ){}


    public function compose(View $view)
    {
        $nodeList = $this->nodeRepository->treePublishedBottomMenu();
        $bottomMenu = $this->buildMenu($nodeList);
        $view->with('bottomMenu', $bottomMenu);
    }
}
