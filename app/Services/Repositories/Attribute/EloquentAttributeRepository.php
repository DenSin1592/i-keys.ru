<?php namespace App\Services\Repositories\Attribute;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Services\RepositoryFeatures\Attribute\PositionUpdater;
use Illuminate\Database\Eloquent\Collection;

class EloquentAttributeRepository
{
    const POSITION_STEP = 10;

    private $positionUpdater;

    private const LIST_TYPE_CODES_1C = [
        '000000001',
        '000000002',
        '000000003',
        '000000004',
        '000000005',
        '000000009',
        '000000010',
        '000000011',
        '000000012',
        '000000013',
        '000000014',
        '000000015',
        '000000016',
        '000000017',
        '000000018',
        '000000019',
        '000000020',
        '000000022',
        '000000025',
        '000000026',
        '000000028',
        '000000029',
        '000000030',
        '000000031',
        '000000037',
    ];


    public function __construct(PositionUpdater $positionUpdater)
    {
        $this->positionUpdater = $positionUpdater;
    }


    public function create(array $data)
    {
        if (\Arr::get($data, 'position') === null) {
            $maxPosition = Attribute::max('position');
            if (is_null($maxPosition)) {
                $maxPosition = 0;
            }
            $data['position'] = $maxPosition + self::POSITION_STEP;
        }

        return Attribute::create($data);
    }

    public function getRelatedCategoriesIdsGroupByAttributeId(): array
    {
        $attributes = Attribute::query()->with('categories')->get();
        $categoriesIdsGroupByAttributeId = [];
        foreach ($attributes as $attribute) {
            $categoriesIdsGroupByAttributeId[$attribute->id] = $attribute->categories->pluck('id')->all();
        }

        return $categoriesIdsGroupByAttributeId;
    }


    public function update(Attribute $attribute, array $data)
    {
        return $attribute->update($data);
    }


    public function all()
    {
        return Attribute::query()->orderBy('position')->get();
    }


    public function newInstance(array $data = [])
    {
        return Attribute::newModelInstance($data);
    }

    /**
     * @param $code1c
     * @return Attribute|null
     */
    public function findByCode1c($code1c)
    {
        return Attribute::query()->where('code_1c', $code1c)->first();
    }

    /**
     * Mark all attributes as not imported
     * use \DB::table update in order not to change update_at
     * and not to run handlers for Model update
     *
     * @return int
     */
    public function resetAllImported()
    {
        return \DB::table('attributes')
            ->where('imported', true)
            ->update(['imported' => false]);
    }

    /**
     * Get type for attribute by code 1c if attributes does not exist
     *
     * @param $code1C
     * @return string
     */
    public function getDefaultAttributeTypeForCode1c($code1C): string
    {
        if (isset($code1C) && in_array($code1C, self::LIST_TYPE_CODES_1C)) {
            $type = Attribute::TYPE_SINGLE;
        } else {
            $type = Attribute::TYPE_STRING;
        }

        return $type;
    }

    /**
     * Mark attribute as imported by id
     * use \DB::table update in order not to change update_at
     * and not to run handlers for Model update
     *
     * @param $id
     * @return int
     */
    public function markAsImportedById($id)
    {
        return \DB::table('attributes')
            ->where('id', $id)
            ->update(['imported' => true]);
    }

    public function getAllNotImportedWithNotEmptyCode1c()
    {
        return Attribute::query()
            ->where('imported', false)
            ->whereNotNull('code_1c')
            ->where('code_1c', '<>', '')
            ->get();
    }

    public function newInstanceWith(Category $category, array $data = [])
    {
        $attribute = $this->newInstance($data);
        $attribute->category()->associate($category);

        return $attribute;
    }

    public function findById($id)
    {
        return Attribute::find($id);
    }


    public function delete(Attribute $attribute)
    {
        return $attribute->delete();
    }


    public function byPage($page, $limit)
    {
        $items = Attribute::query()->orderBy('position')
            ->skip($limit * ($page - 1))->take($limit)
            ->get();
        $total = Attribute::count();

        return [
            'page' => $page,
            'limit' => $limit,
            'items' => $items,
            'total' => $total,
        ];
    }


    public function updatePositions(array $positions)
    {
        $this->positionUpdater->updatePositions(new Attribute(), $positions);
    }


    public function allowedForCategory(Category $category)
    {
        $categoryPath = array_merge($category->extractParentPath(), [$category]);
        $categoryPath = array_reverse($categoryPath);
        $categoryIds = [];
        foreach ($categoryPath as $category) {
            $categoryIds[] = $category->id;
        }
        $attributes = Attribute::query()
            ->join('attribute_category', 'attribute_category.attribute_id', '=', 'attributes.id')
            ->whereIn('attribute_category.category_id', $categoryIds)
            ->orderBy('attributes.position')->select('attributes.*')->distinct()->get();

        return $attributes;
    }


    public function getValues(Product $product, $attributes)
    {
        $stringValuesDict = [];
        $integerValuesDict = [];
        $decimalValuesDict = [];
        $singleValuesDict = [];
        $multipleValuesDict = [];

        if (!is_null($product->id)) {
            $stringValues = $product->attributeStringValues()->get();
            foreach ($stringValues as $value) {
                $stringValuesDict[$value->attribute_id] = $value;
            }

            $integerValues = $product->attributeIntegerValues()->get();
            foreach ($integerValues as $value) {
                $integerValuesDict[$value->attribute_id] = $value;
            }

            $decimalValues = $product->attributeDecimalValues()->get();
            foreach ($decimalValues as $value) {
                $decimalValuesDict[$value->attribute_id] = $value;
            }

            $singleValues = $product->attributeSingleValues()->with('allowedValue')->get();
            foreach ($singleValues as $value) {
                $singleValuesDict[$value->attribute_id] = $value;
            }

            $multipleValues = $product->attributeMultipleValues()
                ->with('allowedValue')
                ->join(
                    'attribute_allowed_values',
                    'attribute_allowed_values.id',
                    '=',
                    'attribute_multiple_values.value_id'
                )
                ->orderBy('attribute_allowed_values.position')
                ->select('attribute_multiple_values.*')
                ->get();
            foreach ($multipleValues as $value) {
                if (!isset($multipleValuesDict[$value->attribute_id])) {
                    $multipleValuesDict[$value->attribute_id] = [];
                }
                $multipleValuesDict[$value->attribute_id][] = $value;
            }
        }

        $productValues = [];
        foreach ($attributes as $attribute) {
            $valueNote = ['attribute' => $attribute];
            switch ($attribute->attribute_type) {
                case Attribute::TYPE_STRING:
                    $valueNote['value'] = \Arr::get($stringValuesDict, $attribute->id, null);
                    break;
                case Attribute::TYPE_INTEGER:
                    $valueNote['value'] = \Arr::get($integerValuesDict, $attribute->id, null);
                    break;
                case Attribute::TYPE_DECIMAL:
                    $valueNote['value'] = \Arr::get($decimalValuesDict, $attribute->id, null);
                    break;
                case Attribute::TYPE_SINGLE:
                    $valueNote['value'] = \Arr::get($singleValuesDict, $attribute->id, null);
                    break;
                case Attribute::TYPE_MULTIPLE:
                    $valueNote['values'] = \Arr::get($multipleValuesDict, $attribute->id, []);
                    break;
            }
            $productValues[] = $valueNote;
        }

        return $productValues;
    }


    public function saveValue(Product $product, Attribute $attribute, $value)
    {
        switch ($attribute->attribute_type) {
            case Attribute::TYPE_STRING:
                $this->saveStringValue($product, $attribute, $value);
                break;
            case Attribute::TYPE_INTEGER:
                $this->saveIntegerValue($product, $attribute, $value);
                break;
            case Attribute::TYPE_DECIMAL:
                $this->saveDecimalValue($product, $attribute, $value);
                break;
            case Attribute::TYPE_SINGLE:
                $this->saveSingleValue($product, $attribute, $value);
                break;
            case Attribute::TYPE_MULTIPLE:
                $this->saveMultipleValue($product, $attribute, $value);
                break;
        }
    }

    public function allForCategory(Category $category)
    {
        $categories = $category->ancestors()->get();
        $categories->add($category);
        $categoryIds = $categories->pluck('id')->all();

        $query = Attribute::query();
        $query->whereIn('category_id', $categoryIds);
        $query->orderBy('position');

        return $query->get();
    }

    /**
     * Save string value.
     *
     * @param Product $product
     * @param Attribute $attribute
     * @param $valueToSave
     */
    private function saveStringValue(Product $product, Attribute $attribute, $valueToSave)
    {
        $this->savePlainValue(
            'attributeStringValues',
            'App\Models\Attribute\StringValue',
            $product,
            $attribute,
            $valueToSave
        );
    }


    /**
     * Save integer value.
     *
     * @param Product $product
     * @param Attribute $attribute
     * @param $valueToSave
     */
    private function saveIntegerValue(Product $product, Attribute $attribute, $valueToSave)
    {
        $this->savePlainValue(
            'attributeIntegerValues',
            'App\Models\Attribute\IntegerValue',
            $product,
            $attribute,
            $valueToSave
        );
    }


    /**
     * Save decimal value.
     *
     * @param Product $product
     * @param Attribute $attribute
     * @param $valueToSave
     */
    private function saveDecimalValue(Product $product, Attribute $attribute, $valueToSave)
    {
        $this->savePlainValue(
            'attributeDecimalValues',
            'App\Models\Attribute\DecimalValue',
            $product,
            $attribute,
            $valueToSave
        );
    }


    /**
     * Save plain value. Need to specify instance association name and value class.
     *
     * @param $relationName
     * @param $valueClass
     * @param Product $product
     * @param Attribute $attribute
     * @param $valueToSave
     */
    private function savePlainValue(
        $relationName,
        $valueClass,
        Product $product,
        Attribute $attribute,
        $valueToSave
    ) {
        if (!is_null($product->id)) {
            $valueInstance = $product->$relationName()->where('attribute_id', $attribute->id)->first();
        } else {
            $valueInstance = null;
        }
        if (is_null($valueToSave) || $valueToSave == '') {
            if (!is_null($valueInstance)) {
                $valueInstance->delete();
                $product->touch();
            }
        } else {
            if (is_null($valueInstance)) {
                $valueInstance = new $valueClass();
                $valueInstance->product()->associate($product);
                $valueInstance->attribute()->associate($attribute);
            }
            $valueInstance->fill(['value' => $valueToSave]);
            if ($valueInstance->isDirty()) {
                $product->touch();
            }
            $valueInstance->save();
        }
    }


    /**
     * Save single value.
     *
     * @param Product $product
     * @param Attribute $attribute
     * @param $valueToSave
     */
    private function saveSingleValue(Product $product, Attribute $attribute, $valueToSave)
    {
        if (!is_null($product->id)) {
            $singleValue = $product->attributeSingleValues()->where('attribute_id', $attribute->id)->first();
        } else {
            $singleValue = null;
        }
        if (is_null($valueToSave) || $valueToSave == '') {
            if (!is_null($singleValue)) {
                $singleValue->delete();
                $product->touch();
            }
        } else {
            if (is_null($singleValue)) {
                $singleValue = new Attribute\SingleValue();
                $singleValue->product()->associate($product);
                $singleValue->attribute()->associate($attribute);
            }
            $singleValue->allowedValue()->associate(Attribute\AllowedValue::find($valueToSave));
            if ($singleValue->isDirty()) {
                $product->touch();
            }
            $singleValue->save();
        }
    }


    /**
     * Save multiple value
     *
     * @param Product $product
     * @param Attribute $attribute
     * @param $valueToSave
     */
    private function saveMultipleValue(Product $product, Attribute $attribute, $valueToSave)
    {
        if (!is_array($valueToSave)) {
            $valueToSave = [];
        }

        if (!is_null($product)) {
            $multipleValues = $product->attributeMultipleValues()->where('attribute_id', $attribute->id)->get();
        } else {
            $multipleValues = Collection::make([]);
        }
        $existingValues = [];
        foreach ($multipleValues as $value) {
            if (!in_array($value->value_id, $valueToSave)) {
                $value->delete();
                $product->touch();
            } else {
                $existingValues[] = $value->value_id;
            }
        }

        $dataToAdd = array_diff($valueToSave, $existingValues);
        foreach ($dataToAdd as $allowedValueId) {
            $multipleValue = new Attribute\MultipleValue();
            $multipleValue->product()->associate($product);
            $multipleValue->attribute()->associate($attribute);
            $multipleValue->allowedValue()->associate(Attribute\AllowedValue::find($allowedValueId));
            $multipleValue->save();
            $product->touch();
        }
    }


    public function findCachedByCode1c($code1c)
    {
        static $attributesByCode1c;

        if (!isset($attributesByCode1c)) {
            $attributesByCode1c = Attribute::query()
                ->whereNotNull('code_1c')
                ->where('code_1c', '<>', '')
                ->get()
                ->keyBy('code_1c');
        }

        return $attributesByCode1c->get($code1c);
    }
}
