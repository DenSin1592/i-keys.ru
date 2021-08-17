<?php namespace App\Models;

class ProductTypePageAssociation extends \Eloquent
{
    protected $fillable = ['name', 'position'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productTypePage()
    {
        return $this->belongsTo(ProductTypePage::class, 'product_type_page_id');
    }
}
