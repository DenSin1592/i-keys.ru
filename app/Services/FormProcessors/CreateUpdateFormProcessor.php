<?php namespace App\Services\FormProcessors;

use App\Services\Repositories\CreateUpdateRepositoryInterface;
use App\Services\Validation\ValidableInterface;

/**
 * Class CreateUpdateFormProcessor
 * @package App\Services\FormProcessors
 */
class CreateUpdateFormProcessor implements CrudFormProcessorInterface
{
    /**
     * @var ValidableInterface
     */
    protected $validator;
    /**
     * @var CreateUpdateRepositoryInterface
     */
    protected $repository;

    /**
     * @param ValidableInterface $validator
     * @param CreateUpdateRepositoryInterface $repository
     */
    public function __construct(ValidableInterface $validator, CreateUpdateRepositoryInterface $repository)
    {
        $this->validator = $validator;
        $this->repository = $repository;
    }

    /**
     * Create an element.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data = [])
    {
        $data = $this->prepareInputData($data);
        if ($this->validator->with($data)->passes()) {
            $instance = $this->repository->create($data);
            $this->afterSuccess($instance, $data);

            return $instance;
        } else {
            return null;
        }
    }

    /**
     * Update an element.
     *
     * @param $instance
     * @param array $data
     * @return boolean
     */
    public function update($instance, array $data = [])
    {
        $data = $this->prepareInputData($data);
        $this->validator->setCurrentId($instance->id);
        if ($this->validator->with($data)->passes()) {
            $this->repository->update($instance, $data);
            $this->afterSuccess($instance, $data);

            return true;
        } else {
            return false;
        }
    }

    /**
     * Get errors.
     *
     * @return array
     */
    public function errors()
    {
        return $this->validator->errors();
    }

    /**
     * Prepare input data before validation and creating/updating.
     *
     * @param array $data
     * @return array
     */
    protected function prepareInputData(array $data)
    {
        return $data;
    }


    /**
     * If some data need to be filtered before save (create and update), do it here.
     * For example, it can be privacy, which should not be even passed to model or
     * data, which will be handled after successful save.
     *
     * @param array $data
     * @return array
     */
    protected function filterSaveData(array $data)
    {
        return $data;
    }


    /**
     * Do something after instance.
     *
     * @param $instance
     * @param array $data
     */
    protected function afterSuccess($instance, array $data)
    {
        // rewrite this method if needed
    }
}
