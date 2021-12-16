<?php


namespace App\Models\Attribute;


class AttributeConstants
{
    public const BRAND_ID = 2;
    public const SECURITY_CLASS = 11;
    public const COUNT_KEYS_IN_SET = 13;
    public const CYLINDER_SERIES = 27;
    public const CYLINDER_OPENING_TYPE = 32;


    public const MAIN_ATTRIBUTES = [
        self::BRAND_ID,
        self::SECURITY_CLASS,
        self::COUNT_KEYS_IN_SET,
        self::CYLINDER_SERIES,
        self::CYLINDER_OPENING_TYPE,
    ];


    public const SIZE_CYLINDER_1C_CODE = '000000013';

}
