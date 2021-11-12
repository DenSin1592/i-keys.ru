<?php

namespace App\Services\Composers;

use App\Services\Composers\Features\CategoryMenuBuilder;
use App\Services\Repositories\Category\EloquentCategoryRepository;


class ClientFooterCategoryComposer
{
    use CategoryMenuBuilder;

    public function __construct(
        private EloquentCategoryRepository $categoryRepository
    ){}


    public function compose($view)
    {
        $categories = $this->categoryRepository->getElementsForFooterMenu();
        $categoriesFooterMenu = $this->buildMenu($categories);
        $view->with('categoriesFooterMenu', $categoriesFooterMenu);
    }
}
