<?php

namespace App\Models;

use App\Models\Attribute\AllowedValue;
use App\Models\Features\Glue;
use App\Models\Helpers\AliasHelpers;
use App\Services\FormProcessors\Features\AutoAlias;
use Diol\Fileclip\UploaderIntegrator;
use Diol\Fileclip\Version\BoxVersion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Service extends \Eloquent
{
    use Glue;
    use HasFactory;
    use AutoAlias;

    public const ADD_KEYS_ID = 1;
    public const ADD_KEYS_ALIAS = 'kopii-klyuchey';

    public const H1 = '{{H1}}';
    public const BREADCRUMBS = '{{BREADCRUMBS}}';

    protected $fillable = [
        'name',
        'alias',
        'image_file',
        'image_remove',
        'content',
        'position',
        'publish',
        'price',
        'description',
        'header',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'icon_file',
        'icon_remove',
    ];


    public function series(): BelongsToMany
    {
        return $this->belongsToMany(AllowedValue::class, 'series_service','service_id', 'series_id', );
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class,);
    }

    protected static function boot()
    {
        parent::boot();

        self::mountUploader(
            'image',
            UploaderIntegrator::getWatermarkedUploader(
                'uploads/services/images',
                [
                    'thumb' => new BoxVersion(100, 100),
                    'list' => new BoxVersion(400, 300),
                ]
            )
        );

        self::mountUploader(
            'icon',
            UploaderIntegrator::getWatermarkedUploader(
                'uploads/services/images/icons',
                [
                    'thumb' => new BoxVersion(100, 100),
                ]
            )
        );

        self::saving(static function (self $product) {
            AliasHelpers::setAlias($product);
        });

        self::deleting(static function (self $model) {
            $model->series()->detach();
            foreach ($model->orderItems as $el){$el->update(['service_id' => null]);}
        });
    }
}
