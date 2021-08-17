<?php namespace App\Http\Controllers\Admin\Attributes;

use App\Http\Controllers\Controller;
use App\Services\Repositories\Category\EloquentCategoryRepository;

/**
 * Class CategoriesController
 * Controller to edit categories for attributes.
 *
 * @package App\Controllers\Admin\Attributes
 */
class CategoriesController extends Controller
{
    private $categoryRepository;

    public function __construct(EloquentCategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function available()
    {
        $categoryTree = $this->categoryRepository->getTree();
        $elements = $this->flattenTree($categoryTree);

        return \Response::json(['elements' => $elements]);
    }


    /**
     * Flatten category tree (recursively).
     *
     * @param $categories
     * @param int $lvl
     * @return array
     */
    private function flattenTree($categories, $lvl = 0)
    {
        $result = [];
        foreach ($categories as $category) {
            $listNamePrefix = '';
            for ($i = 0; $i < $lvl; $i += 1) {
                $listNamePrefix .= '-';
            }
            if ($listNamePrefix !== '') {
                $listName = "{$listNamePrefix} {$category->name}";
            } else {
                $listName = $category->name;
            }

            $result[] = [
                'id' => $category->id,
                'name' => $category->name,
                'listName' => $listName,
            ];
            if (count($category->children) > 0) {
                $result = array_merge($result, $this->flattenTree($category->children, $lvl + 1));
            }
        }

        return $result;
    }


    public function rebuildCurrent()
    {
        $elements = \Request::get('elements');
        if (!is_array($elements)) {
            $elements = [];
        }

        $ids = array_map(function ($e) {
            return \Arr::get($e, 'id');
        }, $elements);

        $categories = $this->categoryRepository->allByIds($ids);
        $content = \View::make('admin.attributes.form.categories._current', [
            'categories' => $categories,
        ])->render();

        return \Response::json(['content' => $content]);
    }
}
