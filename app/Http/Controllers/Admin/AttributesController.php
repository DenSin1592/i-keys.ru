<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Features\ToggleFlags;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Services\Admin\Breadcrumbs\Breadcrumbs;
use App\Services\DataProviders\AttributeForm\AttributeForm;
use App\Services\FormProcessors\Attribute\AttributeFormProcessor;
use App\Services\Repositories\Attribute\EloquentAttributeRepository;
use App\Services\Repositories\Category\EloquentCategoryRepository;
use Request;

class AttributesController extends Controller
{
    use ToggleFlags;

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

    public function index()
    {
        $attributeList = $this->attributeRepository->all();
        if (\Request::ajax()) {
            $content = view('admin.attributes._attribute_list')
                ->with('attributeList', $attributeList)
                ->render();

            return \Response::json(['element_list' => $content]);

        } else {
            return view('admin.attributes.index')
                ->with('attributeList', $attributeList);
        }
    }

    public function create()
    {
        $formData = $this->attributeFormDataProvider->provideDataFor(new Attribute, \Request::old());
        $attributeList = $this->attributeRepository->all();

        return view('admin.attributes.create')
            ->with('attributeList', $attributeList)
            ->with('formData', $formData);
    }

    public function store()
    {
        $attribute = $this->attributeFormProcessor->create(\Request::except('redirect_to'));
        if (is_null($attribute)) {
            return \Redirect::route('cc.attributes.create')
                ->withErrors($this->attributeFormProcessor->errors())->withInput();
        } else {
            if (\Request::get('redirect_to') == 'index') {
                $redirect = \Redirect::route('cc.attributes.index');
            } else {
                $redirect = \Redirect::route('cc.attributes.edit', [$attribute->id]);
            }

            return $redirect->with('alert_success', 'Параметр создан');
        }
    }

    public function edit($attributeId)
    {
        $attribute = $this->getAttribute($attributeId);
        if (is_null($attribute)) {
            \App::abort(404, 'Attribute not found');
        }

        $formData = $this->attributeFormDataProvider->provideDataFor($attribute, \Request::old());
        $attributeList = $this->attributeRepository->all();

        return view('admin.attributes.edit')
            ->with('attributeList', $attributeList)
            ->with('formData', $formData);
    }

    public function update($attributeId)
    {
        $attribute = $this->getAttribute($attributeId);
        if (is_null($attribute)) {
            \App::abort(404, 'Attribute not found');
        }

        $success = $this->attributeFormProcessor->update($attribute, \Request::except('redirect_to'));
        if (!$success) {
            return \Redirect::route('cc.attributes.edit', [$attribute->id])
                ->withErrors($this->attributeFormProcessor->errors())->withInput();
        } else {
            if (\Request::get('redirect_to') == 'index') {
                $redirect = \Redirect::route('cc.attributes.index');
            } else {
                $redirect = \Redirect::route('cc.attributes.edit', [$attribute->id]);
            }

            return $redirect->with('alert_success', 'Параметр обновлён');
        }
    }

    public function destroy($attributeId)
    {
        $attribute = $this->getAttribute($attributeId);

        $attributeRepository = $this->attributeRepository->delete($attribute);

        return \Redirect::route('cc.attributes.index')
            ->with('alert_success', 'Параметр будет удалён в ближайшее время');
    }

    public function updatePositions()
    {
        $this->attributeRepository->updatePositions(\Request::get('positions', []));
        if (\Request::ajax()) {
            return \Response::json(['status' => 'alert_success']);
        } else {
            return \Redirect::back();
        }
    }

    public function toggleAttribute($attributeId, $field)
    {
        if (!in_array($field, ['use_in_filter', 'for_admin_filter', 'hidden'])) {
            \App::abort(404, "Not allowed to toggle this attribute");
        }
        $attribute = $this->getAttribute($attributeId);
        $this->attributeRepository->toggleAttribute($attribute, $field);

        return $this->toggleFlagResponse(
            route('cc.attributes.toggle-attribute', [$attributeId, $field]),
            $attribute,
            $field
        );
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
