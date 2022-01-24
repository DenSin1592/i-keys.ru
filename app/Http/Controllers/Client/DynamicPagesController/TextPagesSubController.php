<?php

namespace App\Http\Controllers\Client\DynamicPagesController;

use App\Http\Controllers\Client\Features\BreadcrumbsHelper;
use App\Models\TextPage;
use App\Services\Breadcrumbs\Factory as Breadcrumbs;
use App\Services\Repositories\Node\EloquentNodeRepository;
use App\Services\Seo\MetaHelper;

class TextPagesSubController
{
    use BreadcrumbsHelper;

    public function __construct(
        private EloquentNodeRepository $nodeRepository,
        private MetaHelper $metaHelper,
        private Breadcrumbs $breadcrumbs
    ) {}


    public function show(TextPage $textPage)
    {
        $node = $textPage->node;

        return \View::make('client.text_page.show', [
            'authEditLink' =>\TypeContainer::getContentUrl($node),
            'textPage' => $textPage,
            'breadcrumbs' => $this->getBreadcrumbsForNode($this->breadcrumbs, $node),
            'metaData' => $this->metaHelper->getRule()->metaForObject($textPage, $node->name),
        ]);
    }
}
