<?php

namespace App\Services\Composers;

use App\Services\Composers\Features\CategoryMenuBuilder;
use App\Services\Repositories\Category\EloquentCategoryRepository;


class ClientHeaderCategoryMenuComposer
{
    use CategoryMenuBuilder;

    private ?array $cache = null;

    public function __construct(
        private EloquentCategoryRepository $categoryRepository
    ){}


    public function compose($view)
    {
        if(is_null($this->cache)){
            $categories = $this->categoryRepository->getElementsForHeaderMenu();
            $this->cache = $this->buildMenu($categories);
        }

        $view->with('categoriesHeaderMenu', $this->cache);
    }
}
