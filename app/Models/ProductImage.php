<?php namespace App\Models;

use App\Models\Features\AutoPublish;
use Diol\Fileclip\UploaderIntegrator;
use Diol\Fileclip\Version\BoxVersion;
use Diol\Fileclip\Version\OutBoundVersion;
use Diol\FileclipExif\Glue;

class ProductImage extends \Eloquent
{
    use Glue;
    use AutoPublish;

    protected $fillable = ['image_file', 'image_remove', 'position', 'publish', 'comment', 'number'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected static function boot()
    {
        parent::boot();

        self::mountUploader(
            'image',
            UploaderIntegrator::getWatermarkedUploader(
                'uploads/products/images',
                [
                    'thumb' => new OutBoundVersion(100, 100),
                    'middle' => new BoxVersion(325, 325),
                    'small' => new BoxVersion(95, 95),
                ]
            )
        );
    }
}
