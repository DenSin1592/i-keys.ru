<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Features\ToggleFlags;
use App\Http\Controllers\Controller;
use App\Services\Admin\Breadcrumbs\Breadcrumbs;
use App\Services\DataProviders\CategoryForm\CategoryForm;
use App\Services\FormProcessors\Category\CategoryFormProcessor;
use App\Services\Repositories\Category\EloquentCategoryRepository;

class CategoriesController extends Controller
{
    use ToggleFlags;

    private $repository;
    private $formDataProvider;
    private $formProcessor;
    private $breadcrumbs;

    public function __construct(
        EloquentCategoryRepository $repository,
        CategoryForm $formDataProvider,
        CategoryFormProcessor $formProcessor,
        Breadcrumbs $breadcrumbs
    ) {
        $this->repository = $repository;
        $this->formDataProvider = $formDataProvider;
        $this->formProcessor = $formProcessor;
        $this->breadcrumbs = $breadcrumbs;
    }

    public function show($id)
    {
        $category = $this->repository->findById($id);
        if (null === $category) {
            \App::abort(404, 'Category is not found');
        }

        $categoryTree = $this->repository->getTree($category);
        $breadcrumbs = $this->breadcrumbs->getFor('category.show', $category);
        if (\Request::ajax()) {
            $content = \View::make('admin.categories._category_list')
                ->with('categoryTree', $categoryTree)->with('lvl', 0)
                ->render();

            return \Response::json(['element_list' => $content]);

        } else {
            return \View::make('admin.categories.index')
                ->with('breadcrumbs', $breadcrumbs)
                ->with('category', $category)
                ->with('categoryTree', $categoryTree);
        }
    }


    public function index()
    {
        $categoryTree = $this->repository->getTree();
        if (\Request::ajax()) {
            $content = \View::make('admin.categories._category_list')
                ->with('categoryTree', $categoryTree)->with('lvl', 0)
                ->render();

            return \Response::json(['element_list' => $content]);

        } else {
            return \View::make('admin.categories.index')
                ->with('categoryTree', $categoryTree);
        }
    }


    public function create($parentId = null)
    {
        $parentCategory = $this->repository->findById($parentId);
        $category = $this->repository->newInstanceWith($parentCategory);
        $formData = $this->formDataProvider->provideDataFor($category, \Request::old());

        $breadcrumbs = $this->breadcrumbs->getFor('category.create', $parentCategory);

        return \View::make('admin.categories.create')
            ->with('breadcrumbs', $breadcrumbs)
            ->with('formData', $formData)
            ->with('categoryTree', $this->repository->getCollapsedTree());
    }


    public function edit($id)
    {
        $category = $this->repository->findById($id);
        if (is_null($category)) {
            \App::abort(404, 'Category not found');
        }
        $formData = $this->formDataProvider->provideDataFor($category, \Request::old());
        $breadcrumbs = $this->breadcrumbs->getFor('category.edit', $category);

        return \View::make('admin.categories.edit')
            ->with('breadcrumbs', $breadcrumbs)
            ->with('formData', $formData)
            ->with('categoryTree', $this->repository->getCollapsedTree($category));
    }


    public function store()
    {
        $category = $this->formProcessor->create(\Request::except('redirect_to'));
        if (is_null($category)) {
            return \Redirect::route('cc.categories.create')
                ->withErrors($this->formProcessor->errors())->withInput();
        } else {
            if (\Request::get('redirect_to') == 'index') {
                if ($category->parent) {
                    $redirect = \Redirect::route('cc.categories.show', $category->parent->id);

                } else {
                    $redirect = \Redirect::route('cc.categories.index');
                }

            } else {
                $redirect = \Redirect::route('cc.categories.edit', $category->id);
            }

            return $redirect->with('alert_success', 'Категория создана');
        }
    }


    public function update($id)
    {
        $category = $this->repository->findById($id);
        if (is_null($category)) {
            \App::abort(404, 'Category not found');
        }

        $success = $this->formProcessor->update($category, \Request::except('redirect_to'));
        if (!$success) {
            return \Redirect::route('cc.categories.edit', $category->id)
                ->withErrors($this->formProcessor->errors())->withInput();
        } else {
            if (\Request::get('redirect_to') == 'index') {
                if ($category->parent) {
                    $redirect = \Redirect::route('cc.categories.show', $category->parent->id);

                } else {
                    $redirect = \Redirect::route('cc.categories.index');
                }

            } else {
                $redirect = \Redirect::route('cc.categories.edit', $category->id);
            }

            return $redirect->with('alert_success', 'Категория обновлена');
        }
    }


    public function destroy($id)
    {
        $category = $this->repository->findById($id);
        if (is_null($category)) {
            \App::abort(404, 'Category not found');
        }
        $parentCategory = $category->parent;
        $this->repository->delete($category);

        $response = \Redirect::route('cc.categories.index');
        if (null !== $parentCategory) {
            $response = \Redirect::route('cc.categories.show', $parentCategory->id);
        }

        return $response->with('alert_success', 'Категория удалена');
    }


    public function updatePositions()
    {
        $this->repository->updatePositions(\Request::get('positions', []));
        if (\Request::ajax()) {
            return \Response::json(['status' => 'alert_success']);
        } else {
            return \Redirect::route('cc.categories.index');
        }
    }


    public function toggleAttribute($id, $attribute)
    {
        if (!in_array($attribute, ['publish'])) {
            \App::abort(404, 'Not allowed to toggle this attribute');
        }
        $category = $this->repository->findById($id);
        if (is_null($category)) {
            \App::abort(404, 'Category not found');
        }
        $this->repository->toggleAttribute($category, $attribute);

        return $this->toggleFlagResponse(
            route('cc.categories.toggle-attribute', [$id, $attribute]),
            $category,
            $attribute
        );
    }
}
