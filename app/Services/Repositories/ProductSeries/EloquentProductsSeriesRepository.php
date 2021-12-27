<?php

namespace App\Services\Repositories\ProductSeries;

use App\Models\ProductsSeries;
use App\Services\Pagination\FlexPaginator;
use Illuminate\Pagination\LengthAwarePaginator;


class EloquentProductsSeriesRepository
{
    public function __construct(
        private FlexPaginator $flexPaginator,
    ){}

    public function create(array $data)
    {
        return ProductsSeries::create($data);
    }

    public function update(\Eloquent $model, $data)
    {
        return $model
            ->fill($data)
            ->save();
    }

    public function findById($id): ?ProductsSeries
    {
        return ProductsSeries::find($id);
    }

    public function findByIdOrFail($id)
    {
        return ProductsSeries::findOrFail($id);
    }

    public function newInstance(array $data = [])
    {
        return ProductsSeries::newModelInstance($data);
    }

    public function delete(ProductsSeries $model)
    {
        return $model->delete();
    }

    private function allByPage($page, $limit)
    {
        $query = ProductsSeries::query();
        $this->scopeOrdered($query);

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

    public function paginate(): LengthAwarePaginator
    {
        return $this->flexPaginator->make(
            function ($page, $limit) {
                return $this->allByPage($page, $limit);
            },
            'review-pagination-page',
            'review-pagination-limit'
        );
    }

    private function scopeOrdered($query)
    {
        return $query->orderBy('created_at', 'DESC');
    }
}
