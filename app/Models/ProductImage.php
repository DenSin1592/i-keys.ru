<?php namespace App\Models;

use App\Models\Features\AutoPublish;
use Diol\Fileclip\UploaderIntegrator;
use Diol\Fileclip\Version\OutBoundVersion;
use Diol\FileclipExif\Glue;

class ProductImage extends \Eloquent
{
    use Glue;
    use AutoPublish;

    protected $fillable = ['image_file', 'image_remove'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected static function boot()
    {
        parent::boot();

        self::mountUploader('image', UploaderIntegrator::getUploader('uploads/products/images', [
            'thumb' => new OutBoundVersion(100, 100),
            // todo: make versions according to layout
        ]));
    }
}
