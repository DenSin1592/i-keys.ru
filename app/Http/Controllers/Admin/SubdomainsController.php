<?php

namespace App\Http\Controllers\Admin;

use App\Services\FormProcessors\Subdomain\SubdomainFormProcessor;
use App\Services\Repositories\Subdomain\EloquentSubdomainRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class SubdomainsController
{
    public function __construct(
        private EloquentSubdomainRepository $repository,
        private SubdomainFormProcessor $formProcessor,
    ){}


    public function index(): View
    {
        $elements = $this->repository->all();

        return \View::make('admin.subdomains.index')
            ->with('elements', $elements);
    }


    public function create(): View
    {
        $entity = $this->repository->newInstance();

        return \View::make('admin.subdomains.create')
            ->with('formData', ['entity' => $entity]);
    }


    public function store()
    {
        $entity = $this->formProcessor->create(\Request::except('redirect_to'));
        if (null === $entity) {
            return \Redirect::route('cc.subdomains.create')
                ->withErrors($this->formProcessor->errors())->withInput();
        }

        if (\Request::get('redirect_to') === 'index') {
            $redirect = \Redirect::route('cc.subdomains.index', $entity->id);
        } else {
            $redirect = \Redirect::route('cc.subdomains.edit', $entity->id);
        }
        return $redirect->with('alert_success', 'Субдомен создан');

    }


    public  function edit(int $id): View
    {
        $entity = $this->repository->findById($id);

        return view('admin.subdomains.edit')
            ->with('formData', ['entity' => $entity]);

    }


    public function update($id)
    {

        $entity = $this->repository->findById($id);
        $success = $this->formProcessor->update($entity, \Request::except('redirect_to'));

        if (!$success) {
            return \Redirect::route('cc.subdomains.edit', $entity->id)
                ->withErrors($this->formProcessor->errors())->withInput();
        }

        if (\Request::get('redirect_to') === 'index') {
            $redirect = \Redirect::route('cc.subdomains.index', $entity->id);
        } else {
            $redirect = \Redirect::route('cc.subdomains.edit', $entity->id);
        }

        return $redirect->with('alert_success', 'Субдомен обновлён');

    }


    public function destroy(int $id): RedirectResponse
    {
        $entity = $this->repository->findById($id);
        $this->repository->delete($entity);

        return \Redirect::route('cc.subdomains.index')->with('alert_success', 'Субдомен удалён');
    }
}
