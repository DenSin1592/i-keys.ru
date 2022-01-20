<?php

namespace App\Models;

use App\Models\Attribute\AllowedValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Service extends Model
{
    use HasFactory;

    public const ADD_KEYS_ID = 1;
    private string $noImageVersion = 'no-image-200x200.png';


    protected $fillable = [
        'name',
        'alias',
        'image',
        'content',
        'position',
        'publish',
        'price',
        'description',
        'header',
        'meta_title',
        'meta_keywords',
        'meta_description',
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

        self::deleting(static function (self $model) {
            $model->series()->detach();

            foreach ($model->orderItems as $el){
                $el->update(['service_id' => null]);
            }

        });
    }

    public function getImageOrStub(): string
    {
        if (! is_null($this->image)){
            return asset('/uploads/services/' . $this->image);
        }
        return asset('/images/common/no-image/' . $this->noImageVersion);
    }
}
