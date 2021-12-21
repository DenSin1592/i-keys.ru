<?php

namespace App\Services\Composers;

use App\Services\Composers\Features\NodeMenuBuilder;
use App\Services\Repositories\Node\EloquentNodeRepository;
use Illuminate\View\View;


class ClientTopMenuComposer
{
    use NodeMenuBuilder;

    private ?array $cache = null;

    public function __construct(
        private EloquentNodeRepository $nodeRepository
    ){}


    public function compose(View $view)
    {
        if(is_null($this->cache)){
            $nodeList = $this->nodeRepository->treePublishedTopMenu();
            $this->cache = $this->buildMenu($nodeList);
        }

        $view->with('topMenu', $this->cache);
    }
}
