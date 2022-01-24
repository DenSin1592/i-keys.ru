<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Client\DynamicPagesController\TextPagesSubController;
use App\Http\Controllers\Controller;
use App\Models\Node;
use App\Services\Repositories\Node\EloquentNodeRepository;


class DynamicPagesController extends Controller
{
    public function __construct(
        private EloquentNodeRepository $nodeRepository,
        private TextPagesSubController $textPagesSubController
    ) {}


    public function show($url)
    {
        $urlQuery = trim($url, '/');
        $aliasPath = explode('/', $urlQuery);
        $nodePath = $this->getNodePath($aliasPath);
        if (count($nodePath) === 0) {
            \App::abort(404, "Node is not found");
        }
        $node = array_pop($nodePath);
        $contentModel = \TypeContainer::getContentModelFor($node);

        if ($node->type === Node::TYPE_TEXT_PAGE) {
            return $this->textPagesSubController->show($contentModel);
        }

        \App::abort(404, 'Unknown page type');
    }


    private function getNodePath(array $aliasPath)
    {
        $nodePath = [];
        $parentNode = null;
        $nodes = $this->nodeRepository->treePublishedWithAliases($aliasPath);
        foreach ($aliasPath as $alias) {
            $alias = mb_strtolower($alias);
            $parentNodeId = is_null($parentNode) ? null : $parentNode->id;
            $matchedNode = null;
            /** @var Node $node */
            foreach ($nodes as $node) {
                if ($node->parent_id === $parentNodeId && mb_strtolower($node->alias) === $alias) {
                    $matchedNode = $node;
                    break;
                }
            }

            if (is_null($matchedNode)) {
                \App::abort(404, "Wrong node path");
            } else {
                if (!is_null($parentNode)) {
                    $matchedNode->parent()->associate($parentNode);
                }
                $nodePath[] = $matchedNode;
                $parentNode = $matchedNode;
            }
        }

        return $nodePath;
    }
}
