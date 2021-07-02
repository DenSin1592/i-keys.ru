<?php namespace App\Services\Repositories\HomePage;

use App\Models\HomePage;
use App\Models\Node;
use App\Services\Repositories\Node\NodeContentRepositoryInterface;

class EloquentHomePageRepository implements NodeContentRepositoryInterface
{
    public function findForNodeOrNew(Node $node)
    {
        $homePage = $node->homePage()->first();
        if (is_null($homePage)) {
            $homePage = new HomePage();
            $homePage->node()->associate($node);
        }

        return $homePage;
    }
}
