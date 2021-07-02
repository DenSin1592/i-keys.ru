<?php namespace App\Services\Repositories\MetaPage;

use App\Models\MetaPage;
use App\Models\Node;
use App\Services\Repositories\Node\NodeContentRepositoryInterface;

class EloquentMetaPageRepository implements NodeContentRepositoryInterface
{
    public function findForNodeOrNew(Node $node)
    {
        $metaPage = $node->metaPage()->first();
        if (is_null($metaPage)) {
            $metaPage = new MetaPage();
            $metaPage->node()->associate($node);
        }

        return $metaPage;
    }
}
