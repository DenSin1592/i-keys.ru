<?php namespace App\Services\Repositories\Product;

use App\Services\Repositories\CreateUpdateRepositoryInterface;

class CreateUpdateWrapper implements CreateUpdateRepositoryInterface
{
    private $repository;

    public function __construct(EloquentProductRepository $repository)
    {
        $this->repository = $repository;
    }


    public function create(array $data)
    {
        return $this->repository->create($data);
    }


    public function update($instance, array $data)
    {
        return $this->repository->update($instance, $data);
    }
}
