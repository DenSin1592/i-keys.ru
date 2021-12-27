<?php

namespace App\Http\Controllers\Admin\Attributes;

use App\Http\Controllers\Controller;
use App\Services\DataProviders\ProductsSeriesForm\ProductsSeriesForm;
use App\Services\FormProcessors\Attribute\ProductsSeries\ProductsSeriesFormProcessor;
use App\Services\Repositories\Attribute\AllowedValue\EloquentAllowedValueRepository;


class ProductsSeriesController extends Controller
{

    public function __construct(
        private ProductsSeriesForm $dataProvider,
        private EloquentAllowedValueRepository $allowedValueRepository,
        private ProductsSeriesFormProcessor $formProcessor,
    ){}


    public function index()
    {
        $modelList = $this->allowedValueRepository->paginateForAdminIndexPage();
        return view('admin.products_series.index', [
            'modelList' => $modelList
        ]);
    }


    public function create()
    {
        $model = $this->allowedValueRepository->newInstance();
        $formData = $this->dataProvider->provideDataFor($model);

        return view('admin.products_series.create', [
            'formData' => $formData,
        ]);
    }


    public function store()
    {
        $model = $this->formProcessor->create(\Request::except('redirect_to'));

        if (is_null($model)) {
            return \Redirect::route('cc.products-series.create', [$model->id])
                ->withErrors($this->formProcessor->errors())->withInput();
        }
        if (\Request::get('redirect_to') === 'index') {
            $redirect = \Redirect::route('cc.products-series.index', [$model->id]);
        } else {
            $redirect = \Redirect::route('cc.products-series.edit', [$model->id]);
        }

        return $redirect->with('alert_success', "Серия создан");

    }


    public function edit($id)
    {
        $model = $this->allowedValueRepository->findById($id);
        $formData = $this->dataProvider->provideDataFor($model);

        return \View::make('admin.products_series.edit',[
            'formData' => $formData,
            'typeSeriesDisabled' => true
        ]);
    }


    public function update($id)
    {
        $model = $this->allowedValueRepository->findById($id);
        $success = $this->formProcessor->update($model, \Request::except('redirect_to'));

        if (!$success) {
            return \Redirect::route('cc.products-series.edit', [ $model->id])->withErrors($this->formProcessor->errors())->withInput();
        }
        if (\Request::get('redirect_to') === 'index') {
            $redirect = \Redirect::route('cc.products-series.index', [$model->id]);
        } else {
            $redirect = \Redirect::route('cc.products-series.edit', [$model->id]);
        }

        return $redirect->with('alert_success', "Товар обновлён");

    }


    public function destroy($id)
    {
        $model = $this->allowedValueRepository->findById($id);
        $this->allowedValueRepository->delete($model);

        return \Redirect::route('cc.products-series.index')->with('alert_success', 'Серия удалёна');
    }
}
