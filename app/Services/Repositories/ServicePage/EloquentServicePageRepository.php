<?php namespace App\Services\Repositories\ServicePage;

use App\Models\Node;
use App\Models\ServicePage;
use App\Services\Repositories\Node\NodeContentRepositoryInterface;

class EloquentServicePageRepository implements NodeContentRepositoryInterface
{
    public function findForNodeOrNew(Node $node)
    {
        $servicePage = $node->servicePage()->first();
        if (is_null($servicePage)) {
            $servicePage = new ServicePage();
            $servicePage->node()->associate($node);
        }

        return $servicePage;
    }
}
