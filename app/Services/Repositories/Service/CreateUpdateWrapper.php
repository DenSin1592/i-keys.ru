<?php namespace App\Services\Repositories\Service;

use App\Services\Repositories\CreateUpdateRepositoryInterface;

/**
 * Class CreateUpdateWrapper
 * Wrapper to connect attributes to standard controllers and form processors.
 *
 * @package App\Services\Repositories\Attribute
 */
class CreateUpdateWrapper implements CreateUpdateRepositoryInterface
{
    private $repository;

    public function __construct(EloquentServiceRepository $repository)
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
