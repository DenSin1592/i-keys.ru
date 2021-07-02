<?php namespace App\Services\Repositories\Product;

use App\Models\Category;
use App\Models\Product;
use App\Services\RepositoryFeatures\Attribute\EloquentAttributeToggler;
use App\Services\RepositoryFeatures\Attribute\PositionUpdater;

class EloquentProductRepository
{
    const POSITION_STEP = 10;

    private $positionUpdater;
    private $attributeToggler;

    public function __construct(PositionUpdater $positionUpdater, EloquentAttributeToggler $attributeToggler)
    {
        $this->positionUpdater = $positionUpdater;
        $this->attributeToggler = $attributeToggler;
    }


    public function allForCategory(Category $category)
    {
        return $category->products()->orderBy('position')->get();
    }

    public function allInCategoryByPage($categoryId, $page, $limit)
    {
        $query = Product::where('category_id', $categoryId)->orderBy('position');

        $total = $query->count();
        $items = $query->skip($limit * ($page - 1))
            ->take($limit)
            ->get();

        return [
            'page' => $page,
            'limit' => $limit,
            'items' => $items,
            'total' => $total,
        ];
    }

    public function updatePositions(array $positions)
    {
        $this->positionUpdater->updatePositions(new Product(), $positions);
    }


    public function toggleAttribute(Product $product, $attribute)
    {
        $this->attributeToggler->toggleAttribute($product, $attribute);
    }


    public function newInstance(array $data = [])
    {
        return new Product($data);
    }


    public function newInstanceWithCategory(Category $category, array $data = [])
    {
        $product = $this->newInstance($data);
        $product->category()->associate($category);

        return $product;
    }


    public function create(array $data = [])
    {
        if (\Arr::get($data, 'position') === null) {
            $maxPosition = Product::where('category_id', \Arr::get($data, 'category_id'))->max('position');
            if (is_null($maxPosition)) {
                $maxPosition = 0;
            }
            $data['position'] = $maxPosition + self::POSITION_STEP;
        }

        return Product::create($data);
    }


    public function update(Product $product, array $data = [])
    {
        return $product->update($data);
    }


    public function delete(Product $product)
    {
        return $product->delete();
    }


    public function findById($id)
    {
        return Product::find($id);
    }
}
