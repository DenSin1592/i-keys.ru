<?php namespace App\Services\DataProviders\AttributeForm\AttributeSubForm;

use App\Models\Attribute;
use App\Services\DataProviders\AttributeForm\AttributeSubForm;
use App\Services\Repositories\Category\EloquentCategoryRepository;

/**
 * Class Categories
 * @package App\Services\DataProviders\AttributeForm\AttributeSubForm
 */
class Categories implements AttributeSubForm
{
    private $categoryRepository;

    public function __construct(EloquentCategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function provideDataFor(Attribute $attribute, array $oldInput)
    {
        if (count($oldInput) > 0) {
            $categoriesOldData = \Arr::get($oldInput, 'categories');
            if (!is_array($categoriesOldData)) {
                $categoriesOldData = [];
            }
            $categoryIds = [];
            foreach ($categoriesOldData as $categoryOldData) {
                $categoryIds[] = $categoryOldData['id'];
            }
            $categories = $this->categoryRepository->allByIds($categoryIds);
        } else {
            $categories = $this->categoryRepository->allForAttribute($attribute);
        }

        return ['categories' => $categories];
    }


    public function isTypeDataProvider()
    {
        return false;
    }
}
