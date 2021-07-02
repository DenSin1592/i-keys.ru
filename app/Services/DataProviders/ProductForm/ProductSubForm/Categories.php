<?php namespace App\Services\DataProviders\ProductForm\ProductSubForm;

use App\Models\Product;
use App\Services\DataProviders\ProductForm\ProductSubForm;
use App\Services\Repositories\Category\EloquentCategoryRepository;

class Categories implements ProductSubForm
{
    private $categoryRepository;

    public function __construct(EloquentCategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }


    public function provideDataFor(Product $product, array $oldInput)
    {
        return [
            'categoryVariants' => $this->categoryRepository->getParentVariants(),
        ];
    }
}
