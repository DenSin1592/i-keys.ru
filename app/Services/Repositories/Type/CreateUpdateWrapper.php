<?php namespace App\Services\Repositories\Type;

use App\Services\Repositories\CreateUpdateRepositoryInterface;

/**
 * Class CreateUpdateWrapper
 * Wrapper for crud form.
 *
 * @package App\Services\Repositories\Category
 */
class CreateUpdateWrapper implements CreateUpdateRepositoryInterface
{
    private $repository;

    public function __construct(EloquentTypeRepository $repository)
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
