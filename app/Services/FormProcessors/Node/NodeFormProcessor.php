<?php namespace App\Services\FormProcessors\Node;

use App\Services\FormProcessors\CreateUpdateFormProcessor;
use App\Services\FormProcessors\Features\AutoAlias;
use App\Services\Repositories\CreateUpdateRepositoryInterface;
use App\Services\StructureTypes\TypeContainer;
use App\Services\Validation\ValidableInterface;

class NodeFormProcessor extends CreateUpdateFormProcessor
{
    use AutoAlias;

    private $typeContainer;

    public function __construct(
        ValidableInterface $validator,
        CreateUpdateRepositoryInterface $repository,
        TypeContainer $typeContainer
    ) {
        parent::__construct($validator, $repository);
        $this->typeContainer = $typeContainer;
    }


    protected function prepareInputData(array $data)
    {
        $data = $this->setAutoAlias($data);

        if (isset($data['type'])) {
            $typeObject = $this->typeContainer->getTypeList()[$data['type']];
            if ($typeObject->getUnique()) {
                $data['alias'] = null;
            }
        }

        return $data;
    }
}
