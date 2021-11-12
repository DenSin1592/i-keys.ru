<?php

namespace App\Services\Repositories\Subdomain;

use App\Models\Subdomain;
use Illuminate\Database\Eloquent\Collection;


class EloquentSubdomainRepository
{

    public function all(): Collection
    {
        return Subdomain::query()->get();
    }


    public function allExcept(int $id)
    {
        return Subdomain::query()->where('id', '<>', $id)->get();
    }


    public function findById(int $id): Subdomain
    {
        return Subdomain::find($id);
    }


    public function findByName($name): Subdomain
    {
        return Subdomain::where('name', $name)->first();
    }


    public function getDefault()
    {
        return Subdomain::find(Subdomain::DEFAULT_SUBDOMAIN_ID);
    }


    public function create(array $data): Subdomain
    {
        return Subdomain::create($data);
    }


    public function update(Subdomain $entity, $data): bool
    {
        return $entity->fill($data)->save();
    }


    public function delete(Subdomain $entity)
    {
        return $entity->delete();
    }


    public function newInstance(array $data = []): Subdomain
    {
        return Subdomain::newModelInstance($data);
    }
}
