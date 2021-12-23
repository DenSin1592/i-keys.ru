<?php namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Node;
use App\Services\Repositories\Node\EloquentNodeRepository;
use App\Services\Seo\MetaHelper;

class ServicesController extends Controller
{
    public function __construct(
        private EloquentNodeRepository $nodeRepository,
        private MetaHelper $metaHelper,
    ){}

    public function __invoke()
    {
        $node = $this->nodeRepository->findByType(Node::TYPE_SERVICES_PAGE);
        $page = \TypeContainer::getContentModelFor($node);

        return response('Hello World', 200);
//            ->with('homePage', $page)
//            ->with('authEditLink', route('cc.service-pages.edit', $page->node_id))
//            ->with('metaData', $this->metaHelper->getRule()->metaForObject($page, $node->name));

    }
}
