<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\Breadcrumbs\Breadcrumbs;
use App\Services\DataProviders\AttributeForm\AttributeForm;
use App\Services\FormProcessors\Attribute\AttributeFormProcessor;
use App\Services\Repositories\Attribute\EloquentAttributeRepository;
use App\Services\Repositories\Category\EloquentCategoryRepository;

class AttributesController extends Controller
{
    private $categoryRepository;
    private $attributeRepository;
    private $attributeFormProcessor;
    private $attributeFormDataProvider;
    private $breadcrumbs;

    public function __construct(
        EloquentCategoryRepository $categoryRepository,
        EloquentAttributeRepository $attributeRepository,
        AttributeFormProcessor $attributeFormProcessor,
        AttributeForm $attributeFormDataProvider,
        Breadcrumbs $breadcrumbs
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->attributeRepository = $attributeRepository;
        $this->attributeFormProcessor = $attributeFormProcessor;
        $this->attributeFormDataProvider = $attributeFormDataProvider;
        $this->breadcrumbs = $breadcrumbs;
    }

    public function index($categoryId)
    {
        $category = $this->getCategory($categoryId);
        $attributeList = $this->attributeRepository->allForCategory($category);
        $breadcrumbs = $this->breadcrumbs->getFor('category.attributes', $category);

        if (\Request::ajax()) {
            $content = \View::make('admin.attributes._attribute_list')
                ->with('attributeList', $attributeList)->with('lvl', 0)
                ->with('category', $category)
                ->render();

            return \Response::json(['element_list' => $content]);

        } else {
            return \View::make('admin.attributes.index')
                ->with('breadcrumbs', $breadcrumbs)
                ->with('category', $category)
                ->with('attributeList', $attributeList);
        }
    }

    public function create($categoryId)
    {
        $category = $this->getCategory($categoryId);
        $attribute = $this->attributeRepository->newInstanceWith($category);
        $formData = $this->attributeFormDataProvider->provideDataFor($attribute, \Request::old());
        $breadcrumbs = $this->breadcrumbs->getFor('category.attribute.create', $category);

        return \View::make('admin.attributes.create')
            ->with('breadcrumbs', $breadcrumbs)
            ->with('formData', $formData);
    }

    public function store($categoryId)
    {
        $category = $this->getCategory($categoryId);
        if (null === $category) {
            \App::abort(404, 'Category is not found');
        }

        $attribute = $this->attributeFormProcessor->create(\Request::except('redirect_to'));
        if (is_null($attribute)) {
            return \Redirect::route('cc.attributes.create', $categoryId)
                ->withErrors($this->attributeFormProcessor->errors())->withInput();
        } else {
            if (\Request::get('redirect_to') == 'index') {
                $redirect = \Redirect::route('cc.attributes.index', $category->id);
            } else {
                $redirect = \Redirect::route('cc.attributes.edit', [$category->id, $attribute->id]);
            }

            return $redirect->with('alert_success', 'Параметр создан');
        }
    }

    public function edit($categoryId, $attributeId)
    {
        $category = $this->getCategory($categoryId);
        $attribute = $this->attributeRepository->findById($attributeId);
        if (is_null($attribute)) {
            \App::abort(404, 'Attribute not found');
        }

        $formData = $this->attributeFormDataProvider->provideDataFor($attribute, \Request::old());
        $breadcrumbs = $this->breadcrumbs->getFor('category.attribute.edit', [$category, $attribute]);

        return \View::make('admin.attributes.edit')
            ->with('breadcrumbs', $breadcrumbs)
            ->with('formData', $formData);
    }

    public function update($categoryId, $attributeId)
    {
        $category = $this->getCategory($categoryId);
        $attribute = $this->getAttribute($attributeId);
        $success = $this->attributeFormProcessor->update($attribute, \Request::except('redirect_to'));

        if (!$success) {
            return \Redirect::route('cc.attributes.edit', [$category->id, $attribute->id])
                ->withErrors($this->attributeFormProcessor->errors())->withInput();
        } else {
            if (\Request::get('redirect_to') == 'index') {
                $redirect = \Redirect::route('cc.attributes.index', [$category->id]);
            } else {
                $redirect = \Redirect::route('cc.attributes.edit', [$category->id, $attribute->id]);
            }

            return $redirect->with('alert_success', 'Параметр обновлён');
        }
    }

    public function destroy($categoryId, $attributeId)
    {
        $category = $this->getCategory($categoryId);
        $attribute = $this->getAttribute($attributeId);
        $this->attributeRepository->delete($attribute);

        return \Redirect::route('cc.attributes.index', $category->id)->with('alert_success', 'Товар удалён');
    }

    public function updatePositions()
    {
        $this->attributeRepository->updatePositions(\Request::get('positions', []));
    }

    /**
     * Get category by id or throw error 404.
     *
     * @param $categoryId
     * @return \App\Models\Category
     */
    private function getCategory($categoryId)
    {
        $category = $this->categoryRepository->findById($categoryId);
        if (is_null($category)) {
            \App::abort(404, 'Category not found');
        }

        return $category;
    }

    /**
     * Get attribute by id or throw error 404.
     *
     * @param $attributeId
     * @return \App\Models\Attribute
     */
    private function getAttribute($attributeId)
    {
        $attribute = $this->attributeRepository->findById($attributeId);
        if (is_null($attribute)) {
            \App::abort(404, 'Attribute not found');
        }

        return $attribute;
    }
}
