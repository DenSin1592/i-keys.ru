<?php namespace App\Models;

use App\Models\Attribute\AllowedValue;
use App\Models\Attribute\StringValue;
use App\Models\Attribute\SingleValue;
use App\Models\Attribute\MultipleValue;
use App\Models\Attribute\IntegerValue;
use App\Models\Attribute\DecimalValue;
use App\Models\Helpers\AliasHelpers;
use App\Models\Helpers\DeleteHelpers;
use Diol\Fileclip\UploaderIntegrator;
use Diol\Fileclip\Eloquent\Glue;
use Diol\Fileclip\Version\OutBoundVersion;
use Diol\FileclipExif\FileclipExif;

class Attribute extends \Eloquent
{
    use Glue;
    use FileclipExif;

    const TYPE_STRING = 'string';
    const TYPE_SINGLE = 'single';
    const TYPE_MULTIPLE = 'multiple';
    const TYPE_INTEGER = 'integer';
    const TYPE_DECIMAL = 'decimal';

    public const SIZE_CYLINDER_1C_CODE = '000000013';

    protected static $attributeNames = [
        self::TYPE_STRING => 'строка',
        self::TYPE_SINGLE => 'выбор из списка',
        self::TYPE_MULTIPLE => 'множественный выбор',
        self::TYPE_INTEGER => 'целое число',
        self::TYPE_DECIMAL => 'дробное число',
    ];

    protected $fillable = ['attribute_type', 'name', 'position', 'decimal_scale', 'units', 'code_1c', 'icon_file', 'icon_remove', 'use_in_filter', 'for_admin_filter', 'filter_name', 'alias', 'hidden', 'imported'];


    /**
     * Default value for decimal scale.
     *
     * @return mixed
     */
    public function getDecimalScaleAttribute()
    {
        return \Arr::get($this->attributes, 'decimal_scale', 2);
    }



    public function allowedValues()
    {
        return $this->hasMany(AllowedValue::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
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

        self::mountUploader('icon', UploaderIntegrator::getUploader('uploads/attributes/icons', [
            'thumb' => new OutBoundVersion(50, 50),
        ]));

        self::deleting(function (self $attribute) {
            DeleteHelpers::deleteRelatedAll($attribute->allowedValues());
            DeleteHelpers::deleteRelatedAll($attribute->stringValues());
            DeleteHelpers::deleteRelatedAll($attribute->integerValues());
            DeleteHelpers::deleteRelatedAll($attribute->decimalValues());
            DeleteHelpers::deleteRelatedAll($attribute->singleValues());
            DeleteHelpers::deleteRelatedAll($attribute->multipleValues());
            $attribute->categories()->detach();
        });
        self::saving(function (self $attribute) {
            AliasHelpers::setAlias($attribute);
        });
    }
}
