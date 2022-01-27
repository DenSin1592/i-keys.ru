<?php


namespace App\Models\Attribute;


class AttributeConstants
{
    public const MAIN = 'main';
    public const OTHER = 'other';
    public const GENERAL = 'general';
    public const TECHNICAL = 'technical';
    public const KEY = 'key';


    public const AUTO_LOCK_ID = 1;
    public const BRAND_ID = 2;
    public const WEIGHT_ID = 3;
    public const DEPARTURE_OF_CROSSBARS_ID = 4;
    public const HEIGHT_ID = 5;
    public const GUARANTEE_ID = 6;
    public const SHACKLE_DIAMETER_ID = 7;
    public const CROSSBAR_DIAMETER_ID = 8;
    public const TEMPERED_CROSSBAR = 9;
    public const SECURITY_CLASS_ID = 11;
    public const KEY_ARTICLE_ID = 12;
    public const COUNT_KEYS_IN_SET_ID = 13;
    public const COUNT_OF_CODE_ELEMENTS_ID = 14;
    public const COUNT_SHACKLES_ID = 15;
    public const SET_ID = 16;
    public const COMES_WITH_A_HANDLE_ID = 17;
    public const CENTER_DISTANCE_ID = 19;
    public const CYLINDER_COATING_ID = 21;
    public const ADDITIONAL_LOCKING_POINTS_PROVIDED_ID = 22;
    public const SHACKLE_OPENING_HEIGHT_ID = 23;
    public const SHACKLE_OPENING_WIDTH_ID = 24;
    public const PRODUCTION_ID = 25;
    public const LOCK_SERIES_ID = 26;
    public const CYLINDER_SERIES_ID = 27;
    public const TYPE_LOCK_ID = 28;
    public const TYPE_LATCH_ID = 29;
    public const TYPE_KEY_ID = 30;
    public const SECRET_MECHANISM_TYPE_ID = 31;
    public const CYLINDER_OPENING_TYPE_ID = 32;
    public const CYLINDER_MECHANISM_TYPE_ID = 34;
    public const SIZE_CYLINDER_ID = 35;
    public const REMOVING_KEY_HOLE_ID = 36;
    public const COLOR_ID = 37;
    public const FRAME_TEMPLATE_ID = 38;
    public const WIDTH_ID = 39;


    public const MAIN_ATTRIBUTES = [
        self::BRAND_ID,
        self::SECURITY_CLASS_ID,
        self::COUNT_KEYS_IN_SET_ID,
        self::LOCK_SERIES_ID,
        self::CYLINDER_SERIES_ID,
        self::CYLINDER_OPENING_TYPE_ID,
    ];


    public const TECHNICAL_ATTRIBUTES = [
        self::COUNT_OF_CODE_ELEMENTS_ID,
        self::DEPARTURE_OF_CROSSBARS_ID,
        self::SHACKLE_DIAMETER_ID,
        self::CROSSBAR_DIAMETER_ID,
        self::TEMPERED_CROSSBAR,
        self::COUNT_SHACKLES_ID,
        self::COMES_WITH_A_HANDLE_ID,
        self::CENTER_DISTANCE_ID,
        self::CYLINDER_COATING_ID,
        self::ADDITIONAL_LOCKING_POINTS_PROVIDED_ID,
        self::SHACKLE_OPENING_HEIGHT_ID,
        self::SHACKLE_OPENING_WIDTH_ID,
        self::TYPE_LOCK_ID,
        self::TYPE_LATCH_ID,
        self::SECRET_MECHANISM_TYPE_ID,
        self::CYLINDER_MECHANISM_TYPE_ID,
        self::REMOVING_KEY_HOLE_ID,
        self::FRAME_TEMPLATE_ID,
        self::SIZE_CYLINDER_ID,
    ];


    public const KEY_ATTRIBUTES = [
       self::TYPE_KEY_ID,
       self::KEY_ARTICLE_ID,
    ];


    public const SERIES_ATTRIBUTES = [
        self::LOCK_SERIES_ID,
        self::CYLINDER_SERIES_ID,
    ];


    public const SERIES_ATTRIBUTES_VARIANTS = [
        self::LOCK_SERIES_ID => 'Серия Замка',
        self::CYLINDER_SERIES_ID => 'Серия Цилиндра',
    ];


    public const CYLINDER_SERIES_1C_CODE = '000000004';
    public const COLOR_1C_CODE = '000000010';
    public const SIZE_CYLINDER_1C_CODE = '000000013';


    public const COLOR_LATUN_ID = 8;
    public const COLOR_NICKEL_ID = 18;

}
