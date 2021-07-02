<?php namespace App\Services\Composers;

use App\Services\Repositories\Node\EloquentNodeRepository;

class ClientTopMenuComposer
{
    private $nodeRepository;

    public function __construct(EloquentNodeRepository $nodeRepository)
    {
        $this->nodeRepository = $nodeRepository;
    }

    public function compose($view)
    {
        $view->with('topMenu', $this->nodeRepository->treePublishedTopMenu());
    }
}
