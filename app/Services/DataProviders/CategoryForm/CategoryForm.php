<?php namespace App\Services\DataProviders\CategoryForm;

use App\Models\Category;
use App\Services\Repositories\Category\EloquentCategoryRepository;

class CategoryForm
{
    private $repository;

    public function __construct(EloquentCategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function provideDataFor(Category $category, array $oldData)
    {
        return [
            'category' => $category,
            'parent' => $category->parent,
            'parentVariants' => $this->repository->getParentVariants($category, '[Корень]'),
            'catalogTypeVariants' => $this->repository->getCatalogTypeVariants(),
        ];
    }
}
