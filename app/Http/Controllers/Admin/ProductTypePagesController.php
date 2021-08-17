<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Features\ToggleFlags;
use App\Http\Controllers\Controller;
use App\Services\Admin\Breadcrumbs\Breadcrumbs;
use App\Services\DataProviders\ProductTypePageForm\ProductTypePageForm;
use App\Services\FormProcessors\ProductTypePage\ProductTypePageFormProcessor;
use App\Services\Repositories\ProductTypePage\EloquentProductTypePageRepository;
use App\Models\ProductTypePage;

/**
 * Class ProductTypePagesController
 * @package App\Http\Controllers\Admin
 */
class ProductTypePagesController extends Controller
{
    use ToggleFlags;

    private $repository;
    private $formProcessor;
    private $formProvider;
    private $breadcrumbs;

    public function __construct(
        EloquentProductTypePageRepository $repository,
        ProductTypePageFormProcessor $formProcessor,
        ProductTypePageForm $formProvider,
        Breadcrumbs $breadcrumbs
    ) {
        $this->repository = $repository;
        $this->formProcessor = $formProcessor;
        $this->formProvider = $formProvider;
        $this->breadcrumbs = $breadcrumbs;
    }

    public function index()
    {
        $productTypePageTree = $this->repository->getTree();
        if (\Request::ajax()) {
            $content = \View::make('admin.product_type_pages._pages_list')
                ->with('productTypePageTree', $productTypePageTree)
                ->with('lvl', 0)
                ->render();

            return \Response::json(['element_list' => $content]);

        } else {
            return \View::make('admin.product_type_pages.index')
                ->with('productTypePageTree', $productTypePageTree);
        }
    }

    public function create()
    {
        $productTypePage = $this->repository->newInstance();
        $breadcrumbs = $this->breadcrumbs->getFor('product_type_page.create', $productTypePage);

        return \View::make('admin.product_type_pages.create')
            ->with($this->formProvider->provideDataFor($productTypePage, \Request::old()))
            ->with('breadcrumbs', $breadcrumbs);
    }

    public function edit($id)
    {
        /** @var ProductTypePage $productTypePage */
        $productTypePage = $this->repository->findById($id);
        if (is_null($productTypePage)) {
            \App::abort(404, 'Product type page is not found');
        }
        $breadcrumbs = $this->breadcrumbs->getFor('product_type_page.edit', $productTypePage);

        return \View::make('admin.product_type_pages.edit')
            ->with($this->formProvider->provideDataFor($productTypePage, \Request::old()))
            ->with('breadcrumbs', $breadcrumbs);
    }

    public function store()
    {
        $productTypePage = $this->formProcessor->create(\Request::except('redirect_to'));
        if (is_null($productTypePage)) {
            return \Redirect::route('cc.product-type-pages.create')
                ->withErrors($this->formProcessor->errors())->withInput();
        } else {
            if (\Request::get('redirect_to') == 'index') {
                $redirect = \Redirect::route('cc.product-type-pages.index');
            } else {
                $redirect = \Redirect::route('cc.product-type-pages.edit', [$productTypePage->id]);
            }

            return $redirect->with('alert_success', trans('Страница создана'));
        }
    }

    public function update($id)
    {
        $productTypePage = $this->repository->findById($id);
        if (is_null($productTypePage)) {
            \App::abort(404, 'Product type page is not found');
        }
        $success = $this->formProcessor->update($productTypePage, \Request::except('redirect_to'));
        if (!$success) {
            return \Redirect::route('cc.product-type-pages.edit', [$id])
                ->withErrors($this->formProcessor->errors())->withInput();
        } else {
            if (\Request::get('redirect_to') == 'index') {
                $redirect = \Redirect::route('cc.product-type-pages.index');
            } else {
                $redirect = \Redirect::route('cc.product-type-pages.edit', [$id]);
            }

            return $redirect->with('alert_success', trans('Страница обновлена'));
        }
    }

    public function destroy($id)
    {
        $productTypePage = $this->repository->findById($id);
        if (is_null($productTypePage)) {
            \App::abort(404, 'Product type page is not found');
        }
        $this->repository->delete($productTypePage);

        return \Redirect::route('cc.product-type-pages.index')->with('alert_success', 'Страница удалена');
    }

    public function updatePositions()
    {
        $this->repository->updatePositions(\Request::get('positions', []));
        if (\Request::ajax()) {
            return \Response::json(['status' => 'alert_success']);
        } else {
            return \Redirect::route('cc.product-type-pages.index');
        }
    }

    public function toggleAttribute($id, $attribute)
    {
        if (!in_array($attribute, ['publish', 'in_left_menu'])) {
            \App::abort(404, "Not allowed to toggle this attribute");
        }
        $productTypePage = $this->repository->findById($id);
        if (is_null($productTypePage)) {
            \App::abort(404, 'Product type page is not found');
        }
        $this->repository->toggleAttribute($productTypePage, $attribute);

        return $this->toggleFlagResponse(
            route('cc.product-type-pages.toggle-attribute', [$id, $attribute]),
            $productTypePage,
            $attribute
        );
    }
}
