<?php namespace App\Models;


use App\Models\OrderItem\OrderExchangeStatus;

class OrderItem extends \Eloquent
{
    use OrderExchangeStatus;

    const MAX_ITEM_COUNT = 4000000000;

    protected $fillable = [
        'product_id',
        'order_id',
        'name',
        'count',
        'price',
        'code_1c',
    ];

    protected $casts = [
        'count' => 'integer',
        'price' => 'double',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function getSummaryPriceAttribute()
    {
        return $this->price * $this->count;
    }
}
