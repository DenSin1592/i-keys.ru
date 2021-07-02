<?php namespace App\Services\Repositories\ProductImage;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Collection;

class EloquentProductImageRepository
{
    const POSITION_STEP = 10;


    public function newInstance(array $data = [])
    {
        return new ProductImage($data);
    }


    public function allForProduct(Product $product)
    {
        return $product->images()->orderBy('position')->get();
    }

    public function createOrUpdateForProduct(Product $product, array $data = [])
    {
        $id = \Arr::get($data, 'id');
        $image = $product->images()->where('id', $id)->first();
        if (is_null($image)) {
            $image = new ProductImage();
            $image->product()->associate($product);
        }

        if (\Arr::get($data, 'position') === null) {
            $maxPosition = $product->images()->max('position');
            if (is_null($maxPosition)) {
                $maxPosition = 0;
            }
            $data['position'] = $maxPosition + self::POSITION_STEP;
        }

        $image->fill($data);
        if ($image->isDirty()) {
            $product->touch();
        }
        $image->save();

        return $image;
    }


    public function deleteById($id)
    {
        $image = ProductImage::find($id);
        if (!is_null($image)) {
            $image->product()->first()->touch();
            $image->delete();
        }
    }


    public function allForProducts($products)
    {
        $productIds = [];
        foreach ($products as $product) {
            $productIds[] = $product->id;
        }

        if (count($productIds) > 0) {
            $images = ProductImage::query()->whereIn('product_id', $productIds)->orderBy('position')->get();
        } else {
            $images = Collection::make([]);
        }

        return $images;
    }
}
