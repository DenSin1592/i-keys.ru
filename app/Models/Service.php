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

    protected $fillable = [
        'name',
        'alias',
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


    protected static function boot()
    {
        parent::boot();

        self::deleting(static function (self $model) {
            $model->series()->detach();
        });
    }
}
