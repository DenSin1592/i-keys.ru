<?php namespace App\Services\DataProviders\TypeForm;

use App\Models\Type;
use App\Services\Repositories\Type\EloquentTypeRepository;

class TypeForm
{
    private $repository;

    public function __construct(EloquentTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function provideDataFor(Type $type, array $oldData)
    {
        return [
            'type' => $type,
            'parent' => $type->parent,
            'category' => $type->category,
            'parentVariants' => $this->repository->getParentVariants($type, '[Корень]'),
            'categoryVariants' => $this->repository->getCategoryVariants($type, '[Корень]'),
        ];
    }
}
