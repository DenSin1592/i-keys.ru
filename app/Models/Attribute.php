<?php namespace App\Models;

use App\Models\Helpers\DeleteHelpers;
use App\Models\Category;
use App\Models\Attribute\AllowedValue;
use App\Models\Attribute\StringValue;
use App\Models\Attribute\SingleValue;
use App\Models\Attribute\MultipleValue;
use App\Models\Attribute\IntegerValue;
use App\Models\Attribute\DecimalValue;

class Attribute extends \Eloquent
{
    const TYPE_STRING = 'string';
    const TYPE_SINGLE = 'single';
    const TYPE_MULTIPLE = 'multiple';
    const TYPE_INTEGER = 'integer';
    const TYPE_DECIMAL = 'decimal';

    protected static $attributeNames = [
        self::TYPE_STRING => 'строка',
        self::TYPE_SINGLE => 'выбор из списка',
        self::TYPE_MULTIPLE => 'множественный выбор',
        self::TYPE_INTEGER => 'целое число',
        self::TYPE_DECIMAL => 'дробное число',
    ];

    protected $fillable = ['category_id', 'attribute_type', 'name', 'position', 'decimal_scale', 'units'];


    /**
     * Default value for decimal scale.
     *
     * @return mixed
     */
    public function getDecimalScaleAttribute()
    {
        return \Arr::get($this->attributes, 'decimal_scale', 2);
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function allowedValues()
    {
        return $this->hasMany(AllowedValue::class);
    }

    public function stringValues()
    {
        return $this->hasMany(StringValue::class);
    }


    public function singleValues()
    {
        return $this->hasMany(SingleValue::class);
    }


    public function multipleValues()
    {
        return $this->hasMany(MultipleValue::class);
    }


    public function integerValues()
    {
        return $this->hasMany(IntegerValue::class);
    }


    public function decimalValues()
    {
        return $this->hasMany(DecimalValue::class);
    }


    /**
     * Getter for "type_name".
     *
     * @return string
     */
    public function getTypeNameAttribute()
    {
        return self::getTypeName($this->attribute_type);
    }


    /**
     * Get attribute type name for attribute type.
     *
     * @param string $attributeType
     * @return string
     */
    public static function getTypeName($attributeType)
    {
        if (isset(self::$attributeNames[$attributeType])) {
            return self::$attributeNames[$attributeType];
        } else {
            return $attributeType;
        }
    }


    /**
     * Get list of attribute types.
     *
     * @return array
     */
    public static function getTypes()
    {
        return array_keys(self::$attributeNames);
    }


    protected static function boot()
    {
        parent::boot();

        self::deleting(function (self $attribute) {
            DeleteHelpers::deleteRelatedAll($attribute->allowedValues());
            DeleteHelpers::deleteRelatedAll($attribute->stringValues());
            DeleteHelpers::deleteRelatedAll($attribute->integerValues());
            DeleteHelpers::deleteRelatedAll($attribute->decimalValues());
            DeleteHelpers::deleteRelatedAll($attribute->singleValues());
            DeleteHelpers::deleteRelatedAll($attribute->multipleValues());
        });
    }
}
