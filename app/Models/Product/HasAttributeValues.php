<?php

namespace App\Models\Product;

use App\Models\Helpers\DeleteHelpers;


trait HasAttributeValues
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributeStringValues()
    {
        return $this->hasMany('App\Models\Attribute\StringValue');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributeIntegerValues()
    {
        return $this->hasMany('App\Models\Attribute\IntegerValue');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributeDecimalValues()
    {
        return $this->hasMany('App\Models\Attribute\DecimalValue');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributeSingleValues()
    {
        return $this->hasMany('App\Models\Attribute\SingleValue');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributeMultipleValues()
    {
        return $this->hasMany('App\Models\Attribute\MultipleValue');
    }


    public function getIdSingleValues(int $id): string
    {
        $data = $this->attributeSingleValues()
            ->where('attribute_id', $id)
            ->first()
            ?->value_id;

        return $data ?? '';
    }


    protected static function bootHasAttributeValues()
    {
        self::deleting(function (self $instance) {
            if (!is_null($instance->id)) {
                DeleteHelpers::deleteRelatedAll($instance->attributeStringValues());
                DeleteHelpers::deleteRelatedAll($instance->attributeSingleValues());
                DeleteHelpers::deleteRelatedAll($instance->attributeMultipleValues());
                DeleteHelpers::deleteRelatedAll($instance->attributeIntegerValues());
                DeleteHelpers::deleteRelatedAll($instance->attributeDecimalValues());
            }
        });
    }
}
