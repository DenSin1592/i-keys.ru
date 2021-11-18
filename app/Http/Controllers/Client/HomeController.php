<?php namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Node;
use App\Services\Repositories\Node\EloquentNodeRepository;
use App\Services\Seo\MetaHelper;

class HomeController extends Controller
{
    public function __construct(
        private EloquentNodeRepository $nodeRepository,
        private MetaHelper $metaHelper,
    ){}

    public function __invoke()
    {
        $node = $this->nodeRepository->findByType(Node::TYPE_HOME_PAGE);
        $page = \TypeContainer::getContentModelFor($node);

        return \View::make('client.home_page.show')
            ->with('homePage', $page)
            ->with('authEditLink', route('cc.home-pages.edit', $page->node_id))
            ->with('metaData', $this->metaHelper->getRule()->metaForObject($page, $node->name));

    }
}
