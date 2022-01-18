<?php namespace App\Http\Controllers\Admin;

//use App\Http\Controllers\Admin\Features\ToggleFlags;
use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\Admin\Breadcrumbs\Breadcrumbs;
use App\Services\DataProviders\ServiceForm\ServiceForm;
use App\Services\FormProcessors\Service\ServiceFormProcessor;
use App\Services\Repositories\Service\EloquentServiceRepository;
//use App\Services\Repositories\Category\EloquentCategoryRepository;
use Request;

class ServicesController extends Controller
{
//    use ToggleFlags;

    public function __construct(
//        private EloquentCategoryRepository $categoryRepository,
        private EloquentServiceRepository $serviceRepository,
        private ServiceFormProcessor $serviceFormProcessor,
        private ServiceForm $serviceFormDataProvider,
//        private Breadcrumbs $breadcrumbs
    ) {
    }

    public function index()
    {
        $serviceList = $this->serviceRepository->all();
        return view('admin.services.index')->with('serviceList', $serviceList);
    }

    public function create()
    {
        $formData = $this->serviceFormDataProvider->provideDataFor(new Service, \Request::old());
        $serviceList = $this->serviceRepository->all();

        return view('admin.services.create')
            ->with('serviceList', $serviceList)
            ->with('formData', $formData);
    }

    public function store()
    {
        $service = $this->serviceFormProcessor->create(\Request::except('redirect_to'));
        if (is_null($service)) {
            return \Redirect::route('cc.services.create')
                ->withErrors($this->serviceFormProcessor->errors())->withInput();
        } else {
            if (\Request::get('redirect_to') == 'index') {
                $redirect = \Redirect::route('cc.services.index');
            } else {
                $redirect = \Redirect::route('cc.services.edit', [$service->id]);
            }

            return $redirect->with('alert_success', 'Услуга создана');
        }
    }

    public function edit($serviceId)
    {
        $service = $this->getService($serviceId);
        if (is_null($service)) {
            \App::abort(404, 'Service not found');
        }

        $formData = $this->serviceFormDataProvider->provideDataFor($service, \Request::old());
        $serviceList = $this->serviceRepository->all();

        return view('admin.services.edit')
            ->with('serviceList', $serviceList)
            ->with('formData', $formData);
    }

    public function update($serviceId)
    {
        $service = $this->getService($serviceId);
        if (is_null($service)) {
            \App::abort(404, 'Service not found');
        }

        $success = $this->serviceFormProcessor->update($service, \Request::except('redirect_to'));
        if (!$success) {
            return \Redirect::route('cc.services.edit', [$service->id])
                ->withErrors($this->serviceFormProcessor->errors())->withInput();
        } else {
            if (\Request::get('redirect_to') == 'index') {
                $redirect = \Redirect::route('cc.services.index');
            } else {
                $redirect = \Redirect::route('cc.services.edit', [$service->id]);
            }

            return $redirect->with('alert_success', 'Услуга обновлена');
        }
    }

    public function destroy($serviceId)
    {
        $service = $this->getService($serviceId);

        $serviceRepository = $this->serviceRepository->delete($service);

        return \Redirect::route('cc.services.index')
            ->with('alert_success', 'Услуга будет удалёна в ближайшее время');
    }

    /**
     * Get service by id or throw error 404.
     *
     * @param $serviceId
     * @return \App\Models\service
     */
    private function getService($serviceId)
    {
        $service = $this->serviceRepository->findById($serviceId);
        if (is_null($service)) {
            \App::abort(404, 'Service not found');
        }

        return $service;
    }
}
