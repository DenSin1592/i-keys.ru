<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Features\ToggleFlags;
use App\Http\Controllers\Controller;
use App\Services\Admin\Breadcrumbs\Breadcrumbs;
use App\Services\DataProviders\TypeForm\TypeForm;
use App\Services\FormProcessors\Type\TypeFormProcessor;
use App\Services\Repositories\Type\EloquentTypeRepository;

/**
 * Class TypesController
 * @package App\Http\Controllers\Admin
 */
class TypesController extends Controller
{
    use ToggleFlags;

    private $repository;
    private $formProcessor;
    private $formDataProvider;
    private $breadcrumbs;

    public function __construct(
        EloquentTypeRepository $repository,
        TypeFormProcessor $formProcessor,
        TypeForm $formDataProvider,
        Breadcrumbs $breadcrumbs
    ) {
        $this->repository = $repository;
        $this->formProcessor = $formProcessor;
        $this->formDataProvider = $formDataProvider;
        $this->breadcrumbs = $breadcrumbs;
    }

    public function show($id)
    {
        $type = $this->repository->findById($id);
        if (null === $type) {
            \App::abort(404, 'Category is not found');
        }

        $typeTree = $this->repository->getTree($type);
        $breadcrumbs = $this->breadcrumbs->getFor('type.show', $type);
        if (\Request::ajax()) {
            $content = \View::make('admin.types._type_list')
                ->with('typeTree', $typeTree)->with('lvl', 0)
                ->render();

            return \Response::json(['element_list' => $content]);

        } else {
            return \View::make('admin.types.index')
                ->with('breadcrumbs', $breadcrumbs)
                ->with('type', $type)
                ->with('typeTree', $typeTree);
        }
    }

    public function index()
    {
        $typeTree = $this->repository->getTree();
        if (\Request::ajax()) {
            $content = \View::make('admin.types._type_list')
                ->with('typeTree', $typeTree)->with('lvl', 0)
                ->render();

            return \Response::json(['element_list' => $content]);

        } else {
            return \View::make('admin.types.index')
                ->with('typeTree', $typeTree);
        }
    }

    public function create($parentId = null)
    {
        $parentType = $this->repository->findById($parentId);
        $type = $this->repository->newInstanceWith($parentType);
        $formData = $this->formDataProvider->provideDataFor($type, \Request::old());

        $breadcrumbs = $this->breadcrumbs->getFor('type.create', $parentType);

        return \View::make('admin.types.create')
            ->with('breadcrumbs', $breadcrumbs)
            ->with('formData', $formData);
    }

    public function store()
    {
        $type = $this->formProcessor->create(\Request::except('redirect_to'));
        if (is_null($type)) {
            return \Redirect::route('cc.types.create')
                ->withErrors($this->formProcessor->errors())->withInput();
        } else {
            if (\Request::get('redirect_to') == 'index') {
                $redirect = \Redirect::route('cc.types.index', $type->id);
            } else {
                $redirect = \Redirect::route('cc.types.edit', $type->id);
            }

            return $redirect->with('alert_success', 'Тип товаров создан');
        }
    }


    public function edit($id)
    {
        $type = $this->repository->findById($id);
        if (is_null($type)) {
            \App::abort(404, 'Type not found');
        }
        $formData = $this->formDataProvider->provideDataFor($type, \Request::old());
        $breadcrumbs = $this->breadcrumbs->getFor('type.edit', $type);

        return \View::make('admin.types.edit')
            ->with('breadcrumbs', $breadcrumbs)
            ->with('formData', $formData);
    }

    public function update($id)
    {
        $type = $this->repository->findById($id);
        if (is_null($type)) {
            \App::abort(404, 'Category not found');
        }

        $success = $this->formProcessor->update($type, \Request::except('redirect_to'));
        if (!$success) {
            return \Redirect::route('cc.types.edit', $type->id)
                ->withErrors($this->formProcessor->errors())->withInput();
        } else {
            if (\Request::get('redirect_to') == 'index') {
                $redirect = \Redirect::route('cc.types.index', $type->id);
            } else {
                $redirect = \Redirect::route('cc.types.edit', $type->id);
            }

            return $redirect->with('alert_success', 'Тип товаров обновлен');
        }
    }


    public function destroy($id)
    {
        $type = $this->repository->findById($id);
        if (is_null($type)) {
            \App::abort(404, 'Type not found');
        }
        $parentType = $type->parent;
        $this->repository->delete($type);

        $response = \Redirect::route('cc.types.index');
        if (null !== $parentType) {
            $response = \Redirect::route('cc.types.show', $parentType->id);
        }

        return $response->with('alert_success', 'Тип товаров удален');
    }


    public function updatePositions()
    {
        $this->repository->updatePositions(\Request::get('positions', []));
        if (\Request::ajax()) {
            return \Response::json(['status' => 'alert_success']);
        } else {
            return \Redirect::route('cc.types.index');
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
            route('cc.types.toggle-attribute', [$id, $attribute]),
            $category,
            $attribute
        );
    }
}
