<?php

namespace App\Services\Repositories\Subdomain;

use App\Services\Repositories\CreateUpdateRepositoryInterface;


class CreateUpdateWrapper implements CreateUpdateRepositoryInterface
{

    public function __construct(
        private EloquentSubdomainRepository $repository
    ){}


    public function create(array $data)
    {
        return $this->repository->create($data);
    }


    public function update($instance, array $data)
    {
        return $this->repository->update($instance, $data);
    }
}
