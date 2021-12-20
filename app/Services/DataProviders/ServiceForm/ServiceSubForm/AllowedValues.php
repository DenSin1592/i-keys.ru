<?php namespace App\Services\DataProviders\AttributeForm\AttributeSubForm;

use App\Models\Attribute;
use App\Services\Eloquent\CollectionExtractor;
use App\Services\Repositories\Attribute\AllowedValue\EloquentAllowedValueRepository;

/**
 * Class AllowedValues
 * Data provider for allowed values form.
 *
 * @package App\Services\DataProviders\AttributeForm\AttributeSubForm
 */
class AllowedValues extends AttributeType
{
    use CollectionExtractor;

    private $allowedValueRepository;

    public function __construct(EloquentAllowedValueRepository $allowedValueRepository)
    {
        $this->allowedValueRepository = $allowedValueRepository;
    }


    protected function provideTypeDataFor($attributeType, Attribute $attribute, array $oldInput)
    {
        if (in_array($attributeType, [Attribute::TYPE_SINGLE, Attribute::TYPE_MULTIPLE])) {
            $allowedValues = $this->getAllowedValues($attribute, $oldInput);
        } else {
            $allowedValues = null;
        }

        return ['allowedValues' => $allowedValues];
    }


    /**
     * Get allowed values.
     *
     * @param Attribute $attribute
     * @param array $oldInput
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    private function getAllowedValues(Attribute $attribute, array $oldInput)
    {
        return $this->extractFromArray(
            function () {
                return $this->allowedValueRepository->newInstance();
            },
            $oldInput,
            'allowed_values',
            $this->allowedValueRepository->allForAttribute($attribute)
        );
    }
}
